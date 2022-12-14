var nodemailer = require('nodemailer');

const host = {
    username : 'shaktipeet1@gmail.com',
    password:'appslure@123'
}

var transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
      user: host.username,
      pass: host.password
    }
});


const shp_send_mail = async (toEmail,subject,message) => {

    var mailOptions = {
        from: host.username,
        to: toEmail,
        subject: subject,
        text: message
      };
      transporter.sendMail(mailOptions, function(error, info){
        if (error) {
          console.log(error);
        } else {
          console.log('Email sent: ' + info.response);
        }
      });
}

  
module.exports = {
    shp_send_mail
}
 