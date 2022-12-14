// 611df726aca08f23a13eb11e   /**send OTP template */
// auth key 1 364702AJDzMKim60fabfbfP1
// auth key 2 364702ATi3IHVSy9B611df61bP1
const authkey = '364702AJDzMKim60fabfbfP1';
const { makeRequest } = require("./axios.helper");

var http = require("https");

// const send_otp_msg91 = (phone,phone_code,sms) => {
//     var options = {
//         "method": "POST",
//         "hostname": "https://api.msg91.com",
//         "port": null,
//         "path": "/api/v5/flow/",
//         "headers": {
//           "authkey": authkey,
//           "content-type": "application/JSON"
//         }
//       };

//       var req = http.request(options, function (res) {
//         var chunks = []
//         res.on("data", function (chunk) {
//           chunks.push(chunk);
//         });
//         res.on("end", function () {
//           var body = Buffer.concat(chunks);
//           console.log(body.toString());
//         });
//       });
//       req.write("{\n\"flow_id\": \"611df726aca08f23a13eb11e\",\n  \"sender\": \"HELPAH\",\n  \"mobiles\": \""+phone_code+""+phone+"\",\n  \"otpnumbr\": \""+sms+"\"}");
//       req.end();
// }


const send_otp_msg91 = async (phone,phone_code='91', otp) => {

    // const url = `https://control.msg91.com/api/sendotp.php?country=${phone_code}&otp=${otp}&sender=ASTHLP&mobile=${phone}&authkey=${authkey}`
    const headers = {
        "authkey": "364702AJDzMKim60fabfbfP1",
        "content-type": "application/JSON"
    }
    // const respo =await makeRequest('get',url,headers,{});

    // console.log(respo.data)

    const url = `https://api.msg91.com/api/v5/flow/`
    const data = {
        "flow_id": "611df726aca08f23a13eb11e",
        "sender": "HELPAH",
        "mobiles": phone_code+''+phone,
        "otpnumbr": otp
    }
    const respo =await makeRequest('post',url,headers,data);
    // console.log('====================================');
    // console.log(respo);
    // console.log('====================================');
    return;

};

module.exports = {
    send_otp_msg91
}