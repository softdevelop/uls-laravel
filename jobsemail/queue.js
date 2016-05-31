
var nodemailer = require('nodemailer');
var mongodb = require('mongodb');
var exec = require('child_process').exec;

//get config set up email.
var config = require('./config.js');

// create reusable transporter object using the default SMTP transport
var transporter = nodemailer.createTransport(config.smtpConfig);

var MongoClient = mongodb.MongoClient;

// Connection URL. This is where your mongodb server is running.
var url = config.connectionUrlMongo.url;
var itemsProcessing = {};
var db;

var sendEmail = function(data, database, callback) {
    db = database;
    // var collectionJobs = collection;
    // setup e-mail data with unicode symbols
    var mailOptions = {
        from: config.emailFrom, // sender address
        to: data.email, // list of receivers
        subject: data.title, // Subject line
        html: data.html, // html body
    };

    // if (typeof data.attach != 'undefined') {

    //     var pathFileAttach = data.attach.file;

    //     if (data.attach.ext_attach == 'html') {
    //         exec('wkhtmltopdf -O landscape --dpi 300 '+data.attach.file+ ' ' + data.attach.folder_path + data.attach.filename);
    //         pathFileAttach = data.attach.folder_path + data.attach.filename;
    //     }


    //     mailOptions.attachments = [
    //         {
    //             filename:data.attach.filename,
    //             path: pathFileAttach
    //         }
    //     ];
    // }

    // send mail with defined transport object
    transporter.sendMail(mailOptions, function(error, info){
            // Get the documents collection
            var collection = db.collection('email_jobs');
             if(error){
                console.log(error);
                collection.update({_id:data._id}, {$set:{status:'fail'}});
            } else {
                collection.update({_id:data._id}, {$set:{status:'success'}});
                if(data.type && data.type == 'accounts_payable') {

                    var logData = data.log;
                    var collectionActivity = db.collection('activity_log');
                    logData.created_at = logData.updated_at = new Date();
                    collectionActivity.insert(logData);
                }
            }

    });
}


var idsIsRunning = [];

//queue send email.
var queueSendEmail = function (database) {
    db = database;
    // Get the documents collection
    var collection = db.collection('email_jobs');

    // Insert some users
    var results = collection.find({status:'none', _id:{$nin:idsIsRunning}}).sort({'created_at':1}).limit(10).toArray(function(err, result) {

        if (err) {
              console.log(err);
        } else if (result.length) {
            var ids = [];
            for(var i in result) {
                ids.push(result[i]._id);
            }
            idsIsRunning = ids;

            collection.update({_id:{$in: ids}}, {$set:{status:'processing'}}, {multi: true}, function(){
                for (var key in result) {
                    sendEmail(result[key], database);
                }
            });


          } else {
            console.log('No document(s) found with defined "find" criteria!');
          }

    });

}



module.exports = queueSendEmail;

