var CronJob = require('cron').CronJob;
//get config set up email.
var config = require('./config.js');
var queueSendEmail = require('./queue.js');
var mongodb = require('mongodb');
var MongoClient = mongodb.MongoClient;
// Connection URL. This is where your mongodb server is running.
var url = config.connectionUrlMongo.url;
// Use connect method to connect to the Server
MongoClient.connect(url, function (err, db) {
    if (err) {
        console.log('Unable to connect to the mongoDB server. Error:', err);
      } else {

        //init cron job run every 1 mininute.
        new CronJob('*/3 * * * * *', function() {
              // console.log('1');
            queueSendEmail(db);
        }, null, true, 'America/Los_Angeles');
      }
});






