require ("./config/config");
const kafka = require('kafka-node');
const http = require('http');
var express = require('express');
var axios = require('axios');

var _ = require('lodash');
var app = express();

app.use(function (req, res, next) {
  req.headers["content-type"] = "application/json";
  next();
});



app.get("/topicsList",(req,res)=>{
  try {
    var data ={};
    const kafkaClient = new kafka.KafkaClient({kafkaHost: '172.16.32.30:9092'});
    const admin = new kafka.Admin(kafkaClient);

    admin.listTopics((err, res1) => {
      let kafkaTopicsArray=Object.keys(res1[1]['metadata']);
      console.log('Host : ', res1[0]['0']['host']);
      console.log('Topics : ', kafkaTopicsArray);

      //data["host"] = res1[0]['0']['host'];
      data["topics"] = kafkaTopicsArray;
      //alert('Topics : ', kafkaTopicsArray);
      res.send(kafkaTopicsArray);
   //   client.emit('getKafkaTopics',{data:kafkaTopicsArray});
    });

  }
  catch(e) {
    res.send(400);
  }
});





const port = process.env.PORT;
app.listen(port, () => {
  console.log(`Started on port ${port}`);
});
module.exports = {app};
