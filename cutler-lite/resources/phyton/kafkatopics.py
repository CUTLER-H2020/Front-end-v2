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
            es_url = 'http://10.10.2.56:9200'
            kafka_url = '10.10.2.51:9092'
        elif server == 'p1':
            es_url = 'http://10.20.3.40:9200'
            kafka_url = '10.20.3.30:9092'
        elif server == 'p2':
            es_url = 'http://172.16.32.40:9200'
            kafka_url = '172.16.32.30:9092'
        elif server == 'p3':
            es_url = 'http://172.16.33.40:9200'
            kafka_url = '172.16.33.30:9092'
        else:       # if server == 'uniko':
            es_url = 'http://141.26.209.12:9200'
            kafka_url = '141.26.208.227:9092'
    else:   # local test (but rely on remote ES)
        es_url = 'http://141.26.209.12:9200'
        kafka_url = 'localhost:9092'

    kafka_topic = 'ALL_SOC_NEWS_COMMENT_CRAWLING_REALTIME'

    consumer = KafkaConsumer(
        bootstrap_servers=[kafka_url],
        auto_offset_reset='latest',
        enable_auto_commit=True,
        value_deserializer=lambda x: json.loads(x.decode('utf-8')),
        api_version=(2, 2, 1)
    )

    producer = KafkaProducer(
        bootstrap_servers=[kafka_url],
        value_serializer=lambda x: json.dumps(x).encode('utf-8'),
        api_version=(2, 2, 1)
    )

    print('Kafka interface testing started.')

    request_id = int(uuid.uuid4())
    keyword = 'Trump'
    start_date = '2020-01-25'
    end_date = '2020-02-24'

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

