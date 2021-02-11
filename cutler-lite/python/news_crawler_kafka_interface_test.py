#!/usr/bin/env python3
#./news_crawler_kafka_interface_test [ SERVER (uniko / dell) ]
import json
import sys
import uuid

from kafka import KafkaProducer, KafkaConsumer, TopicPartition
from kafka.errors import KafkaError

# main
if __name__ == "__main__":
    if len(sys.argv) > 1:
        # params
        server = sys.argv[1]

        # Elasticsearch connection
        if server == 'dell':
            kafka_url = '10.10.2.51:9092'
        elif server == 'p1':
            kafka_url = '172.16.34.30:9093'
            ssl_cafile='../ssl/kafka-ssl/p1/ca-cert'
            ssl_certfile = '../ssl/kafka-ssl/p1/cutler-p01-c2-0.crt'
            ssl_keyfile = '../ssl/kafka-ssl/p1/cutler-p01-c2-0.key'
        elif server == 'p2':
            kafka_url = '172.16.32.30:9093'
            ssl_cafile='../ssl/kafka-ssl/p2/ca-cert'
            ssl_certfile = '../ssl/kafka-ssl/p2/cutler-p2-c2-00.crt'
            ssl_keyfile = '../ssl/kafka-ssl/p2/cutler-p2-c2-00.key'
        elif server == 'p3':
            kafka_url = '172.16.33.30:9093'
            ssl_cafile='../ssl/kafka-ssl/p3/ca-cert'
            ssl_certfile = '../ssl/kafka-ssl/p3/cutler-p3-c2-00.crt'
            ssl_keyfile = '../ssl/kafka-ssl/p3/cutler-p3-c2-00.key'
        elif server == 'p4':
            kafka_url = '172.16.34.30:9092'
    else:   # local test
        server = 'localhost'
        kafka_url = 'localhost:9092'

    kafka_topic = 'ALL_SOC_NEWS_COMMENT_CRAWLING_REALTIME'

    if server in ['localhost', 'uniko', 'p4']:
        consumer = KafkaConsumer(
            bootstrap_servers=[kafka_url],
            auto_offset_reset='latest',
            enable_auto_commit=True,
            value_deserializer=lambda x: json.loads(x.decode('utf-8')),
            api_version=(2, 0, 1),
         )

        producer = KafkaProducer(
            bootstrap_servers=[kafka_url],
            value_serializer=lambda x: json.dumps(x).encode('utf-8'),
            api_version=(2, 0, 1),
         )
    else:
        consumer = KafkaConsumer(
            bootstrap_servers=[kafka_url],
            auto_offset_reset='latest',
            enable_auto_commit=True,
            value_deserializer=lambda x: json.loads(x.decode('utf-8')),
            api_version=(2, 0, 1),
            security_protocol='SSL',
            ssl_cafile=ssl_cafile,
            ssl_certfile=ssl_certfile,
            ssl_keyfile=ssl_keyfile
         )

        producer = KafkaProducer(
            bootstrap_servers=[kafka_url],
            value_serializer=lambda x: json.dumps(x).encode('utf-8'),
            api_version=(2, 0, 1),
            security_protocol='SSL',
            ssl_cafile=ssl_cafile,
            ssl_certfile=ssl_certfile,
            ssl_keyfile=ssl_keyfile
        )

    print('Kafka interface testing started.')

    request_id = int(uuid.uuid4())
    keyword = 'Corona'
    start_date = '2020-06-04'
    end_date = '2020-06-05'

    keyword = sys.argv[2]
    start_date = sys.argv[3]
    end_date = sys.argv[4]

    request = {'type': 'request', 'request_id': request_id, 'keyword': keyword, 'start_date': start_date, 'end_date': end_date }
    print('request ', request)

    # send request
    future = producer.send(kafka_topic, value=request)

    # Block for 'synchronous' sends
    try:
        record_metadata = future.get(timeout=10)
    except KafkaError:
        # Decide what to do if produce request failed...
        log.exception()
        pass

    # get topic, partition and offset
    topic = record_metadata.topic
    partition = record_metadata.partition
    offset = record_metadata.offset

    partition = TopicPartition(topic, partition)

    consumer.assign([partition])
    consumer.seek(partition, offset)

    for message in consumer:
        content = message.value
        print(content)
        response_id = content.get('response_id')

        if response_id == request_id:
            break;

    consumer.close()

