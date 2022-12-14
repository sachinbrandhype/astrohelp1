var FCM = require('fcm-node');
const { Notification, Astrologer, User, AstrologerNotification, Broadcast, BookBroadcast } = require('../models');
const { currentTimeStamp } = require('./user.helper');
var serverKey = 'AAAASiCBx_0:APA91bEFg-o01tvj86QiCtxS7L9OwP_FJ0n7vaB-HHGucY2QC3Ixm9ZUWfhxVeXsZAEo0GgLbxuf4jn0Ms-94YSneZQxEqsUCXURzUjdqg_GAV0NXDoxKcuqTPLRmgKWEU2BPgJ9sb2C'; //put your server key here

var astrologerappserverkey = 'AAAAtkqjKPM:APA91bEfdA79_gYNJ2GlJQJNMjY7ZoPXGtYiOQsDUOFKAqRs8jWO4nXj0VTPNIw1mKqMoELnxoMBIMrskVfaVftLfaZu7enqjiWGmwiQusRid8DCS3M-emutLH9xmmLjAURn4MJhOM5y';
var fcm = new FCM(serverKey);
var collapseKey = 'com.astrohelp24';
const axios = require('axios');
const { adminBaseUrl } = require('../config/app.config');
const { Op } = require('sequelize');
const nodeschedule = require('node-schedule');

// zCUnwWUcG4MwTmkF1fI4HVm3C4Ym3Hdm1OxEx7cm
const send_fcm_push =async (token,title,message,data={},priority='normal') => {

    const dateTime = currentTimeStamp();
    const storedata = {
        user_id:data.user_id ? data.user_id : 0,
        user_type:1,
        title:title,
        notification:message,
        added_on:dateTime
    }

    await Notification.create(storedata)

    var msg_obj =  {
        title: title, 
        body: message,
        icon: 'ic_notification',
        color: '#18d821',
        sound: 'default',
        priority: priority
        // priority:'high'
    };

    var message = { //this may vary according to the message type (single recipient, multicast, topic, et cetera)
        to: token, 
        // registration_ids
        collapse_key: collapseKey,
        // "data": {}, "from": "846252768029", "messageId": "0:1615101213059689%35fb841e35fb841e", 
        notification:msg_obj,
        
        data: msg_obj
    };

    fcm.send(message, function(err, response){
        if (err) {
            console.log("Something has gone wrong!");
        } else {
            console.log("Successfully sent with response: ", response);
        }
    });
   
}

const send_fcm_push_astrologer =async (token,title,message,data={},priority='normal') => {
    const SERVER_KEY = `AAAAA-Vq-4w:APA91bHMazogQxvqHJqR8N9Uz0gC6UeVaH4SRC4YFILWUqsytLcxNrkhm750cdczKBvwsctBTZRVWSlRJNACPpRedPbiVbXYnyy0Y_AihAPpPZFUfZauiJM3r2XlZkDXeEldAE-EnKjt`
    const dateTime = currentTimeStamp();
    const storedata = {
        user_id:data.astrologer_id ? data.astrologer_id : 0,
        for_:'astrologer',
        title:title,
        notification:message,
        added_on:dateTime
    }

    await AstrologerNotification.create(storedata)

    var fcm2 = new FCM(SERVER_KEY);

    var msg_obj =  {
        title: title, 
        body: message,
        icon: 'ic_notification',
        color: '#18d821',
        sound: 'default',
        priority: priority
    };

    var message = { //this may vary according to the message type (single recipient, multicast, topic, et cetera)
        to: token, 
        // registration_ids
        collapse_key: 'com.astrohelp24a',
        // "data": {}, "from": "846252768029", "messageId": "0:1615101213059689%35fb841e35fb841e", 
        notification:msg_obj,

        data: msg_obj
    };

    fcm2.send(message, function(err, response){
        if (err) {
            console.log("Something has gone wrong!");
        } else {
            console.log("Successfully sent astrologerapp with response: ", response);
        }
    });

}

const send_push_through_curl = async (user_id,title,message,data={}) => {
    const dateTime = currentTimeStamp();

    const storedata = {
        user_id:user_id ?user_id : 0,
        user_type:1,
        title:title,
        notification:message,
        added_on:dateTime
    }

    await Notification.create(storedata)

    axios({
      method: 'post',
      url: adminBaseUrl+'test_ctrl/send_push_notification',
      data:{
        user_id:user_id,
        title:title,
        message:message,
        data:data,
      }
    })
    .then(rs=>console.log('send',rs.data))
    .catch(rs=>console.log('not send',rs))
    ;
}

const send_booking_request_notification = async (type,user_id,astrologer_id,queue_book=false) => {
    console.log('send_booking_request_notification');
    var booking_type = '';
    const b_type=type;
    if(b_type==1){
        booking_type='Video';
    }else if(b_type == 2){
        booking_type='Audio'
    }else if(b_type == 3){
        booking_type='Chat'
    }else if(b_type == 4){
        booking_type='Report'
    }else if(b_type == 5){
        booking_type='Broadcast'
    }

    const astrologer = await Astrologer.findOne({
        where:{
            id:astrologer_id
        }
    })

    const user = await User.findOne({
        where:{
            id:user_id
        }
    })

    const title = `${booking_type} Request Sent!`
    var message;
    if(queue_book){
         message = `Your request has been sent to ${astrologer.name.toUpperCase()}, You will be notified when astrologer accepts your request !`;

    }else{
         message = `Your request has been sent to ${astrologer.name.toUpperCase()}, You will be notified when astrologer accepts your request, Your request will rejected automatically after 2 minutes if astrologer does not respond to the request.`;

    }

    // const title2 = `New ${booking_type} Request `;
    const message2 = `Hi  ${astrologer.name.toUpperCase()}, You have one new ${booking_type} Request. This request will rejected automatically after 2 minutes if you does not respond to the request.`;
    const title2 = message2;

    send_fcm_push(user.device_token,title,message,{user_id:user_id})
    // if(b_type == 2){
    //     send_fcm_push_astrologer(astrologer.device_token,title2,message2,{astrologer_id:astrologer.id})

    // }else{
    //     send_fcm_push_astrologer(astrologer.device_token,title2,message2,{astrologer_id:astrologer.id},'high')

    // }
    send_fcm_push_astrologer(astrologer.device_token,title2,message2,{astrologer_id:astrologer.id})


}

const reject_request_notification = async (user_id,astrologer_id,by='user' )=> {
    const astrologer = await Astrologer.findOne({
        where:{
            id:astrologer_id
        }
    })

    const user = await User.findOne({
        where:{
            id:user_id
        }
    })
    var reject_by='';
    if(by=='user'){
        reject_by=user.name
        const title = "Request rejected successfully!"
        const message = `Your request has been rejected successfully!`

        const title2 = `Request rejected by ${reject_by}!`
        const message2 = `Request has been rejected by ${reject_by}, Due to some reason!`

        send_fcm_push(user.device_token,title,message,{user_id:user.id})
        send_fcm_push_astrologer(astrologer.device_token,title2,message2,{astrologer_id:astrologer.id})
    }else if(by=='astrologer'){
        reject_by = 'astrologer '+astrologer.name;

        const title2 = "Request rejected successfully!"
        const message2 = `Request has been rejected successfully!`

        const title = `Request rejected by ${reject_by}!`
        const message = `Request has been rejected by ${reject_by}, Due to some reason!`

        send_fcm_push(user.device_token,title,message,{user_id:user.id})
        send_fcm_push_astrologer(astrologer.device_token,title2,message2,{astrologer_id:astrologer.id})
    }

return true;

}


const cancel_booking_notification = async (booking) => {

    const astrologer = await Astrologer.findOne({
        where:{
            id:booking.assign_id
        }
    })
    var booking_type = '';

    const b_type=booking.type;
    if(b_type==1){
        booking_type='Video';
    }else if(b_type == 2){
        booking_type='Audio'
    }else if(b_type == 3){
        booking_type='Chat'
    }else if(b_type == 4){
        booking_type='Report'
    }else if(b_type == 5){
        booking_type='Broadcast'
    }

    const user = await User.findOne({
        where:{
            id:booking.user_id
        }
    })

    const title = `Booking ${booking_type} Cancelled #${booking.id}`;
    const message = `Hi ${user.name.toUpperCase()}, Your booking with astrologer ${astrologer.name.toUpperCase()} has been cancelled successfully.`;;
    send_fcm_push(user.device_token,title,message,{user_id:booking.user_id})

}


const cancel_booking_notification_auto = async (booking) => {

    const astrologer = await Astrologer.findOne({
        where:{
            id:booking.assign_id
        }
    })
    var booking_type = '';

    const b_type=booking.type;
    if(b_type==1){
        booking_type='Video';
    }else if(b_type == 2){
        booking_type='Audio'
    }else if(b_type == 3){
        booking_type='Chat'
    }else if(b_type == 4){
        booking_type='Report'
    }else if(b_type == 5){
        booking_type='Broadcast'
    }

    const user = await User.findOne({
        where:{
            id:booking.user_id
        }
    })

    const title = `Booking Cancelled #${booking.id}`;
    const message = `Hi ${user.name.toUpperCase()}, Your booking with astrologer ${astrologer.name.toUpperCase()} has been cancelled by the system, becuase you have not responded the request.`;;
    send_fcm_push(user.device_token,title,message,{user_id:booking.user_id})

}


const send_booking_complete_notification = async (type,user_id,astrologer_id,order_id,txn_amount) => {
    console.log('send_booking_complete_notification');
    var booking_type = '';
    const b_type=type;
    if(b_type==1){
        booking_type='Video Call';
    }else if(b_type == 2){
        booking_type='Audio Call'
    }else if(b_type == 3){
        booking_type='Chat'
    }else if(b_type == 4){
        booking_type='Report'
    }else if(b_type == 5){
        booking_type='Broadcast'
    }

    const astrologer = await Astrologer.findOne({
        where:{
            id:astrologer_id
        }
    })

    const user = await User.findOne({
        where:{
            id:user_id
        }
    })


    // const title2 = `Wallet debit against Order ID #${order_id}`
    // const message2 = `Your wallet amount is debited with Rs.${txn_amount}.`;

    // send_fcm_push(user.device_token,title2,message2,{user_id:user_id})

    const title = `${booking_type} Complete Order ID #${order_id}`
    const message = `Your ${booking_type} with ${astrologer.name.toUpperCase()} has been completed successfully.`;

    send_fcm_push(user.device_token,title,message,{user_id:user_id})



}


const horoscope_book_notification = async (user_id,astrologer_id,horoscope_nam,order_id) => {
    const user = await User.findOne({
        where:{
            id:user_id
        }
    })
    const astrologer = await Astrologer.findOne({
        where:{
            id:astrologer_id
        }
    })

    // for ${horoscope_nam}

    const title = `Horoscope ${horoscope_nam} Order ID #${order_id}`;
    const message = `Your Horoscope Request has been sent to ${astrologer.name.toUpperCase()}, You will be notified when astrologer sent you horoscope report, you can see your horoscope report in the booking history section`
    send_fcm_push(user.device_token,title,message,{user_id:user_id});


    const title2 = `New Horoscope ${horoscope_nam} Booking Order ID #${order_id}`;
    const message2 = `Hi ${astrologer.name.toUpperCase()}, You have one new Booking for ${horoscope_nam.toUpperCase()} .`
    send_fcm_push_astrologer(astrologer.device_token,title2,message2,{astrologer_id:astrologer.id});

}

const auto_reject_booking_req_notify = async (user_id,astrologer_id) => {

    const user = await User.findOne({where:{
        id:user_id
    }})
    const title= "Booking Request Auto Rejected"
    const message = `Hi ${user.name.toUpperCase()}, Your request has been rejected because there was no response from the astrologer, Please try again with other astrologer`;
    send_fcm_push(user.device_token,title,message,{user_id:user_id});
}

// const send_request_notification_to_astrologer = async (user_id,astrologer_id)


const accept_reject_book_notification = async (type,user_id,astrologer_id,order_id) => {
    var booking_type = '';
    const b_type=type;
    if(b_type==1){
        booking_type='Video Call';
    }else if(b_type == 2){
        booking_type='Audio Call'
    }else if(b_type == 3){
        booking_type='Chat'
    }else if(b_type == 4){
        booking_type='Report'
    }else if(b_type == 5){
        booking_type='Broadcast'
    }
    const user = await User.findOne({
        where:{
            id:user_id
        }
    })
    const astrologer = await Astrologer.findOne({
        where:{
            id:astrologer_id
        }
    })

    const title = `${booking_type} Request Accepted Order Id #${order_id}`;
    const message = `Hi ${user.name.toUpperCase()}, Your ${booking_type} Request has been accepted by astrologer ${astrologer.name.toUpperCase()}, Please join ${booking_type}, Thank you!`;

    send_fcm_push(user.device_token,title,message,{user_id:user_id});

}


const accept_reject_user_book_notification_astrologer = async (type,user_id,astrologer_id,order_id,accept=true) => {
    try {
        var booking_type = '';
        const b_type=type;
        if(b_type==1){
            booking_type='Video Call';
        }else if(b_type == 2){
            booking_type='Audio Call'
        }else if(b_type == 3){
            booking_type='Chat'
        }else if(b_type == 4){
            booking_type='Report'
        }else if(b_type == 5){
            booking_type='Broadcast'
        }
        const user = await User.findOne({
            where:{
                id:user_id
            }
        })
        const astrologer = await Astrologer.findOne({
            where:{
                id:astrologer_id
            }
        })
        if(accept){
            const title = `${booking_type} Request Accepted by ${user.name} Order Id #${order_id}`;
            const message = `Hi ${astrologer.name.toUpperCase()}, ${booking_type} Request has been accepted by ${user.name}, Thank you!`;
            send_fcm_push_astrologer(astrologer.device_token,title,message,{astrologer_id:astrologer.id});
        
        }else{
            const title = `${booking_type} Request Rejected by ${user.name} Order Id #${order_id}`;
            const message = `Hi ${astrologer.name.toUpperCase()}, ${booking_type} Request has been rejected by ${user.name}, Thank you!`;
            send_fcm_push_astrologer(astrologer.device_token,title,message,{astrologer_id:astrologer.id});
        
        }
        return true
    } catch (error) {
        return false;
    }
 
   

}

const send_alert_for_event =async (broadcast_id) => {
    const broadcast = await Broadcast.findOne({
        where:{
            status:{
                [Op.ne]:[2]
            },
            is_approved:1,
            id:broadcast_id
        }
    })
    if(broadcast){
        const momenttime = moment(broadcast.start_time).format('YYYY-MM-DD HH:mm:ss');

        const rule = new nodeschedule.RecurrenceRule();
        const schedule_arr = momenttime.split(" ");
        const schedule_date_month_year = schedule_arr[0].split("-");
        const schedule_time = schedule_arr[1].split(":");

        rule.date= parseInt(schedule_date_month_year[2])
        rule.month=parseInt(schedule_date_month_year[1])-1
        rule.year=parseInt(schedule_date_month_year[0])
        rule.hour = parseInt(schedule_time[0]);
        rule.minute = parseInt(schedule_time[1])+1;
        rule.tz = 'Asia/Calcutta';

        const job = nodeschedule.scheduleJob(rule,async function(){
            // console.log('The answer to life, the universe, and everything!');
            const book_broadcasts = await BookBroadcast.findAll({
                where:{
                    broadcast_id:broadcast_id
                }
            })
            if(book_broadcasts){
                for (let bd of book_broadcasts) {
                    const user = await User.findOne({
                        where:{
                            id:bd.user_id
                        },
                        attributes:['id','device_token','name']
                    })
                    if(user){
                        const astrologer = await Astrologer.findOne({
                            attributes:['id','device_token','name'],
                            where:{
                                id:bd.astrologer_id
                            }
                        })
                        const title = `${astrologer.name} has started the broadcast event`;
                        const message = `Hi ${user.name} , Please join the broadcast event!`;
                        send_fcm_push(user.device_token,title,message,{user_id:user.id});

                    }

                }
            }
        });
    }
}

module.exports = {
    send_fcm_push,
    send_fcm_push_astrologer,
    send_booking_request_notification,
    send_booking_complete_notification,
    send_push_through_curl,
    auto_reject_booking_req_notify,
    horoscope_book_notification,
    accept_reject_book_notification,
    cancel_booking_notification_auto,
    cancel_booking_notification,
    reject_request_notification,
    send_alert_for_event,
    accept_reject_user_book_notification_astrologer
}
