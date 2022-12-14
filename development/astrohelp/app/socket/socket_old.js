process.env.TZ = "Asia/Calcutta";

// var app = require("express")();
// var http = require("http").createServer(app);
// var io = require("socket.io")(http);
var moment = require("moment");
const { jwtsecret } = require("../config/app.config");
const { booking_status_function, end_live_session_function, astrologer_dynamic_function, set_astrologer_comission_to_order, fetch_user_queue_fun } = require("../controllers/home.controller");
const {
  User,
  Bookingrequest,
  Broadcastjoin,
  Booking,
	sequelize,
  Transaction,
  Broadcast,
  Member
} = require("../models/index");
const jwt = require("jsonwebtoken");
const db = require("../models/index");
const cors = require("cors");
const bodyParser = require("body-parser");
const { currentTimeStamp,checkIfAstrologerBusyTime } = require("../helpers/user.helper");
const { successRes, failedRes } = require("../helpers/response.helper");
const { Op } = require("sequelize");
const { send_booking_request_notification, send_booking_complete_notification, auto_reject_booking_req_notify, accept_reject_book_notification, cancel_booking_notification_auto, cancel_booking_notification, reject_request_notification } = require("../helpers/notification.helper");
const { send_gifts_function, astrologer_bag_pack } = require("../controllers/gift.controller");
const { delete_broadcast_ant_media } = require("../helpers/antmedia.helper");

var broadcast_joiners_timeout;
var cancel_booking_timeout;
var broadcast_timeout_time = 1000*60*5;
var create_broadcast_event;
const get_user_id_by_token = async (token) => {
  //  jwt.verify(token, jwtsecret, (err, decoded) => {
  //     if (err){
  //       return 0;
  //     }else{
  //       return decoded.id;
  //     }
  // });

  let promise = new Promise(function (resolve, reject) {
    jwt.verify(token, jwtsecret, (err, decoded) => {
      if (err) {
        reject(0);
      } else {
        resolve(decoded.id);
      }
    });
  });

  return promise;
};

const get_json = async (string) => {
  const data = string;
  if (data.token) {
    data.user_id = await get_user_id_by_token(data.token);
  }
  return data;
};


module.exports = (io) => {
  console.log('====================================');
  console.log('socket log');
  console.log('====================================');

  io.on("connection", (socket) => {
    var USERID;

    io.emit("user connected");
    console.log(socket.rooms);

    let counter = 0;
    setInterval(() => {
      socket.emit("hello", ++counter);
    }, 1000);

    socket.on("test", async () => {
      const user = await User.findOne();
      console.log(user);
      io.emit("test", user);
    });

    socket.on("hello", async () => {
      console.log("Hello event fire");
    });

    // socket.on('booking_request',(req,res)=>{
    //   // const data = (req.body)
    // })

    // const

    socket.on("get_booking_status", async (req) => {
      const { user_id } = await get_json(req);
      socket.join(user_id);
      await booking_status_event_emit(user_id)
      // socket.join(user_id);
      // USERID = user_id;
      // const data = await booking_status_function(user_id);
      // io.sockets.in(user_id).emit("get_booking_status", data);
    });

    const get_booking_status = async (user_id) => {
      const data = await booking_status_function(user_id);
      return data;
    };

    const booking_status_event_emit =async (user_id) => {
      socket.join(user_id);
      const data = await booking_status_function(user_id);
      io.sockets.in(user_id).emit("get_booking_status", data);
    }


    const callback_for_booking_rejection = async (ids) => {
      const dt = await Bookingrequest.findOne({
        where: {
          id: ids,
        },
      });
      const user_id = dt.user_id+'';
      socket.join(user_id)


      await Bookingrequest.destroy({
        where: {
          id: ids,
          status: 0,
        },
      });

      if (dt.status == 0) {
        auto_reject_booking_req_notify(user_id,dt.astrologer_id)

        // const data = await booking_status_function(dt.user_id);
        // io.sockets.in(user_id).emit("get_booking_status", data);
        await booking_status_event_emit(user_id)

        const atro_id=dt.astrologer_id
        await astro_dynamic_func(atro_id)

        // io.emit("get_booking_status", data);
      }
    };


    socket.on("astrologer_realtimebook", async (req) => {
      const {
        token,
        user_id,
        astrologer_id,
        price_per_mint,
        type,
      } = await get_json(req);

      // console.log('realtime',req);
      // USERID=user_id
      socket.join(user_id);

      const check1 = await Bookingrequest.findOne({
        where: {
          status: {
            [Op.in]: [0],
          },
          user_id: user_id,
        },
        order: [["id", "desc"]],
      });

      if (check1) {
        // const sdata = await get_booking_status(user_id);
        // io.sockets.in(user_id).emit("get_booking_status", sdata);
        await booking_status_event_emit(user_id)

        const atro_id=check1.astrologer_id
        await astro_dynamic_func(atro_id)
      
      } else {
        const check = await Bookingrequest.findOne({
          where: {
            status: {
              [Op.in]: [0],
            },
            user_id: user_id,
            astrologer_id: astrologer_id,
            type: type,
          },
          order: [["id", "desc"]],
        });
        const member =await Member.findOne({
            order:[
                ['id','desc']
            ],
            where:{
                user_id:user_id,
            }
        })

        const dateTime = moment().format("YYYY-MM-DD HH:mm:ss");
        if (check) {
          const updateDatA = {
            member_id:member.id,
            price_per_mint: price_per_mint,
            created_at: dateTime,
          };
          await Bookingrequest.update(updateDatA, {
            where: {
              id: check.id,
            },
          });
          const rid = check.id;
          console.log("crid", rid);
          setTimeout(() => {
            console.log(rid);

            callback_for_booking_rejection(rid);
          }, 1000 * 60 * 2);

          // io.emit('astrologer_realtimebook',successRes('done',check))

          io.sockets
            .in(user_id)
            .emit("astrologer_realtimebook", successRes("done", check));

            const atro_id=astrologer_id
            await astro_dynamic_func(atro_id)

            await user_queue(user_id)
        } else {
          
          const checkifastrologeranylivebooking = await  checkIfAstrologerBusyTime(astrologer_id)
          const storeData = {
            user_id: user_id,
            astrologer_id: astrologer_id,
            price_per_mint: price_per_mint,
            member_id:member.id,
            status: checkifastrologeranylivebooking ? 4 : 0,
            type,
            created_at: dateTime,
          };
          const rs = await Bookingrequest.create(storeData);
          const rid = rs.id;
          console.log("rid", rid);

          if(!checkifastrologeranylivebooking){
            setTimeout(() => {
              console.log(rid);
              callback_for_booking_rejection(rid);
            }, 1000 * 60 * 2);
            await send_booking_request_notification(type,user_id,astrologer_id)
    
          }else{
            await send_booking_request_notification(type,user_id,astrologer_id,true)

          }
        
          //  io.emit('astrologer_realtimebook',successRes('done',rs))
          io.sockets
            .in(user_id)
            .emit("astrologer_realtimebook", successRes("done", rs));

        
            const atro_id=astrologer_id
            await astro_dynamic_func(atro_id)

            await booking_status_event_emit(user_id)
            await user_queue(user_id)
          //  const sdata= await get_booking_status(user_id)

          //  io.emit('get_booking_status',successRes('done',sdata))
        }
      }
    });

    // socket.on('give_review',async (req)=>{
    //   console.log(req);

    //   if(req.user_id==53){
    //     socket.join(53);
    //     io.sockets.in(53).emit('give_review',{user_id:req.user_id})
    //   }

    // })

    const GenerateUniqueID = function () {
      // Math.random should be unique because of its seeding algorithm.
      // Convert it to base 36 (numbers + letters), and grab the first 9 characters
      // after the decimal.
      return  Math.random().toString(36).substr(2, 9);
    };

    socket.on("accept_reject_booking", async (req) => {
      console.log('ACCEPT REJECT BOOKING',req);
      var { id, what, user_id,astrologer_id } = req;
      socket.join(user_id);

      // console.log("req", req);
      user_id = parseInt(user_id);
      const booking = await Booking.findOne({
        where:{
          user_id:user_id,
          // is_premium:0,
          // id:id,
          status:{
            [Op.in]:[0,1]
          },
          type:{
            [Op.in]:[1,2,3]
          },
          // schedule_date_time:{
          //   [Op.gt]: todaydate+' 00:00:00',
          //   [Op.lt]: todaydate+' 24:00:00'
          // }
        },
        order:[
          ['id','asc']
        ]
      })
      if(what == 1){
        
        if(booking){
          const user =await User.findOne({
            where:{
              id:user_id
            }
          });
          var wallet =parseFloat(user.wallet);

          // var seconds_per_duratiion = 60 ;
          // var price_per_duration = parseFloat(price_per_mint);
          // var total_sets = Math.floor(wallet/price_per_duration);
          // var total_amount = total_sets*price_per_duration;
          // var total_seconds = total_sets*seconds_per_duratiion;
          // var total_minutes = Math.round(total_seconds/60);

          var price_per_mint = parseFloat(booking.price_per_mint);
          var total_minutes =Math.round(wallet/price_per_mint);
          var total_seconds = total_minutes*60;
      
          const updatebooking = await Booking.update({
            total_minutes:total_minutes,
            status:1,
            time_minutes:total_minutes,
            total_seconds:total_seconds,
            payable_amount:wallet
          },{
            where:{
              id:booking.id
            }
          }).then((rs)=>{
            io.sockets
            .in(user_id)
            .emit("astrologer_realtimebook", successRes("done", rs));
            cancel_booking_timeout = setTimeout(() => {
              callback_for_cancel_booking(booking.id)
            }, 120*1000);
    
            accept_reject_book_notification(booking.type,booking.user_id,booking.assign_id,booking.id)
      
          })

          
        }
    
      

      }else if(what==2){
        reject_request_notification(user_id?user_id:0,astrologer_id,'astrologer')
      }

      await astro_dynamic_func(astrologer_id)
      
    
      // const sdata = await get_booking_status(user_id);
      // io.sockets.in(user_id).emit("get_booking_status", sdata);
      await booking_status_event_emit(user_id)

      await user_queue(user_id)
    });


    socket.on('accept_reject_user_booking',async (req) => {
      const {user_id,booking_id,what} = req;

      console.log('accept_reject_user',req);
      socket.join(user_id);

      if(cancel_booking_timeout){
        clearTimeout(cancel_booking_timeout)
      }
      const booking = await Booking.findOne({
        where:{
          user_id:user_id,
          // is_premium:0,
          status:{
            [Op.in]:[0,1]
          },
          type:{
            [Op.in]:[1,2,3]
          },
          id:booking_id
        },
        order:[
          ['id','asc']
        ]
      });
      if(what == 1){

        if(booking){
          const user =await User.findOne({
            where:{
              id:user_id
            }
          });
      
          var wallet =parseFloat(user.wallet);
          var price_per_mint = parseFloat(booking.price_per_mint);
          var total_minutes =Math.round(wallet/price_per_mint);
          var total_seconds = total_minutes*60;
          const dateTime=currentTimeStamp();
      
          const updatebooking = await Booking.update({
            total_minutes:total_minutes,
            time_minutes:total_minutes,
            schedule_date_time:dateTime,
            status:6,
            is_confirmed:1,
            total_seconds:total_seconds,
            payable_amount:wallet
          },{
            where:{
              id:booking.id
            }
          }).then(async(rs)=>{


            const sdata = await get_booking_status(booking.user_id);
            io.sockets
            .in(user_id)
            .emit("accept_reject_user_booking", sdata);

            await booking_status_event_emit(user_id)  /**hss */
            // io.sockets.in(user_id).emit("get_booking_status", sdata);

            // accept_reject_book_notification(booking.type,booking.user_id,booking.assign_id,booking.id)
            setTimeout(() => {
              callback_for_complete_booking(booking.id)
            }, total_seconds*1000);
          })
        }
      }else{
        await callback_for_cancel_booking(booking_id,'noauto')
      
        await booking_status_event_emit(user_id)
        // io.sockets.in(user_id).emit("get_booking_status", sdata);
        reject_request_notification(user_id?user_id:0,booking.assign_id,'user')
      }
      if(booking){
        const atro_id= booking.assign_id
        await astro_dynamic_func(atro_id)
        await user_queue(booking.user_id)
      }

    })

    const callback_for_cancel_booking = async (booking_id,type='auto') => {
      // console.log('callback_for_cancel_booking'+booking_id+type);
      var booking;
      if(type=='auto'){
        booking = await Booking.findOne({
          where:{
            id:booking_id,
            status:{
              [Op.ne]:[6]
            },
            is_confirmed:0
          }
        })
      }else{
        booking = await Booking.findOne({
          where:{
            id:booking_id,
            status:{
              [Op.in]:[0,1,6]
            }
          }
        })
      }
    
      if(booking){
        socket.join(booking.user_id);
        const b_type = booking.type;
        if(b_type==1){
          booking_type='Video Call Booking';
        }else if(b_type == 2){
          booking_type='Audio Call Booking'
        }else if(b_type == 3){
          booking_type='Chat Booking'
        }else if(b_type == 4){
          booking_type='Report Booking'
        }else if(b_type == 5){
          booking_type='Broadcast Booking'

        }

        await Booking.update({
          status:3,
          is_paid:0
        },{
          where:{
            id:booking.id,
            status : {
              [Op.in]:[0,1,6]
            }
          }
        })
        if(type=='auto'){
          cancel_booking_notification_auto(booking)
        }else{
          // cancel_
          cancel_booking_notification(booking);
        }

        const sdata = await get_booking_status(booking.user_id);
        // io.sockets.in(booking.user_id).emit("get_booking_status", sdata);

        // await booking_status_event_emit(booking.user_id)

        io.sockets
        .in(booking.user_id)
        .emit("accept_reject_user_booking", sdata);

        // io.sockets
        // .in(booking.user_id)
        // .emit("get_booking_status", sdata);

        const atro_id= booking.assign_id
        await astro_dynamic_func(atro_id)
        if(booking){
           await booking_status_event_emit(booking.user_id)
          
        }
        await user_queue(booking.user_id)
      }
    }

    const callback_for_complete_booking =async (booking_id) =>{
      const booking = await Booking.findOne({
        where:{
          id:booking_id,
          status:{
            [Op.in]:[0,1,6]
          }
        }
      })
      var booking_type='';
    
      socket.join(booking.user_id);

      if(booking){
        const b_type = booking.type;
        if(b_type==1){
          booking_type='Video Call Booking';
        }else if(b_type == 2){
          booking_type='Audio Call Booking'
        }else if(b_type == 3){
          booking_type='Chat Booking'
        }else if(b_type == 4){
          booking_type='Report Booking'
        }else if(b_type == 5){
          booking_type='Broadcast Booking'
        }

        const txn_id = GenerateUniqueID()+booking.user_id;
        const user = await User.findOne({
          where:{id:booking.user_id}
        })
        
        var old_wallet = parseFloat(user.wallet);
        var txn_amount =  parseFloat(booking.payable_amount);
        var new_wallet = old_wallet-txn_amount;
        var txn_type = 'debit';
        const end_time = currentTimeStamp();

        var transactiondata = {
          user_id:booking.user_id,
          payment_mode:'wallet',
          txn_name:'Astrologer '+booking_type,
          booking_id:booking.id,
          booking_txn_id:txn_id,
          txn_for:'booking',
          type:txn_type,
          old_wallet:old_wallet,
          txn_amount:txn_amount,
          update_wallet:new_wallet,
          status:1,
          created_at:end_time,
          updated_at:end_time,
    
        };
        const t = await sequelize.transaction();
        try {
          await Booking.update({
            status:2,
            end_time:end_time,
            txn_id:txn_id,
            is_paid:1
          },{
            where:{
              id:booking.id,
              status : {
                [Op.in]:[0,1,6]
              }
            }
          }, { transaction: t })
    
          await User.update({
            wallet:new_wallet
          },{
            where:{
              id:booking.user_id
            }
          },  { transaction: t })
          const dt = await Transaction.create(transactiondata
            , { transaction: t });
          await t.commit();

          // const sdata = await get_booking_status(booking.user_id);
          // io.sockets.in(booking.user_id).emit("get_booking_status", sdata);
          await booking_status_event_emit(booking.user_id)

          io.sockets
          .in(booking.user_id)
          .emit("give_review", { status: true, user_id: booking.user_id });

          send_booking_complete_notification(b_type,booking.user_id,booking.assign_id,booking.id,txn_amount);

          const atro_id= booking.assign_id
          await astro_dynamic_func(atro_id)
          await set_astrologer_comission_to_order(booking.id)
          await user_queue(booking.user_id)
          // return res.json(successRes('done!!',booking))
        }catch (error) {
          // If the execution reaches this line, an error was thrown.
          // We rollback the transaction.
          await t.rollback();
          // callback_for_booking_rejection(booking.id)

          // return res.json(failedRes('failed!!'));
        }


          
      }

    
    }

    socket.on("end_live_session", async (req) => {
      var { user_id, token ,booking_id} = await get_json(req);

      console.log("req", req);
      socket.join(user_id);

      // const sdata = await get_booking_status(user_id);
      // io.sockets.in(user_id).emit("get_booking_status", sdata);
      await booking_status_event_emit(user_id)

      io.sockets
        .in(user_id)
        .emit("give_review", { status: true, user_id: user_id });

        // if(sdata.status===true && sdata.data){
        //   const atro_id= sdata.data.assign_id
        //   await astro_dynamic_func(atro_id)
        // }

        const bk = await Booking.findOne({where:{id:booking_id}})
        await astro_dynamic_func(bk?bk.assign_id:0)
         user_queue(bk?bk.user_id:0)
    });

    socket.on('end_live_session_by_astrologer',async (req)=>{
      const {user_id,astrologer_id,booking_id,bridge_id}=req;
      socket.join(user_id);
      socket.join(bridge_id);
      const end_session = await end_live_session_function(user_id,booking_id);
      if(end_session.status){
        io.sockets.in(bridge_id).emit('end_live_session_by_astrologer',end_session);

        await booking_status_event_emit(user_id)

        io.sockets
        .in(user_id)
        .emit("give_review", { status: true, user_id: user_id });

        const bk = await Booking.findOne({where:{id:booking_id}})
        await astro_dynamic_func(bk?bk.assign_id:0)
        user_queue(bk?bk.user_id:0)
      }
    })


    socket.on('end_broadcast',async (req)=>{
      const {astrologer_id,bridge_id} = req;
      socket.join(bridge_id);

      const check =await Broadcast.findOne({
        where:{
          bridge_id,
          status:{
            [Op.in]:[2]
          }
        }
      })

      const dateTime = currentTimeStamp();

      if(check){
        io
        .sockets
        .in(bridge_id)
        .emit("end_broadcast", { status: true, bridge_id: bridge_id });
      }else{
        io
        .sockets
        .in(bridge_id)
        .emit("end_broadcast", { status: false, bridge_id: bridge_id });
      }

    })


    

    socket.on('leave_broadcast',async (req) => {
      
      console.log('leave',req);
      const {user_id,bridge_id,astrologer_id} = req;
      socket.join(bridge_id);
      const dateTime = currentTimeStamp();
      await Broadcast.scope(['start']).findOne({
      where:{ bridge_id:bridge_id }
      }).then(async (broadcast)=>{
        if(broadcast){
          const check =await Broadcastjoin.findOne({
            where : {
              user_id:user_id,
              bridge_id:bridge_id,
              astrologer_id:astrologer_id
            }
          })

          if(check){
            await Broadcastjoin.update({
              status:2
            },{
              where:{
                id:check.id
              }
            })
          }

          // const users =await Broadcastjoin.scope(['join','newest']).findAll().then(async (joiners)=>{
          //   for (let joiner of joiners) {
          //     joiner.dataValues.user = await User.findOne({
          //       where:{
          //         id:joiner.user_id
          //       }
          //     })
          //   }
          //   return await joiners;
          // });


          // io.sockets
          // .in(bridge_id)
          // .emit("leave_broadcast", { status: true, data: users });
        }else{
          // io.sockets
          // .in(bridge_id)
          // .emit("leave_broadcast", { status: true, data: [] });
        }
      })

    const users = await audience_list(bridge_id)

      io
      .sockets
      .in(bridge_id)
      .emit("leave_broadcast", { status: true, data: users ? users : [] });

      
      io
      .sockets
      .in(bridge_id)
      .emit("audience_list_update", { status: true, data: users ? users : [] });
    })

    const audience_list = async (bridge_id) => {
      const users =await Broadcastjoin.scope(['newest']).findAll({
        where:{
          bridge_id:bridge_id,
          status:1
        }
      }).then(async (joiners)=>{
        for (let joiner of joiners) {
          joiner.dataValues.user = await User.findOne({
            where:{
              id:joiner.user_id
            }
          })
        }
        return await joiners;
      });

      return users;

    }

    socket.on('join_broadcast',async (req) => {
      const {user_id,bridge_id,astrologer_id} = req;
      console.log('join',req);
      socket.join(bridge_id);
      const dateTime = currentTimeStamp();
      const broadcast =await Broadcast.findOne({
      where:{ bridge_id:bridge_id }
      })
      if(broadcast){
        const check =await Broadcastjoin.findOne({
          where : {
            user_id:user_id,
            bridge_id:bridge_id,
            astrologer_id:astrologer_id
          }
        })

        if(check){
          await Broadcastjoin.update({
            status:1,
            created_at:dateTime
          },{
            where:{
              id:check.id,
            }
          })
        }else{
          const storeData = {
            user_id:user_id,
            broadcast_id:broadcast.id,
            bridge_id:bridge_id,
            astrologer_id:astrologer_id,
            status:1,
            created_at:dateTime
          }
          await Broadcastjoin.create(storeData);
        }

      }else{
        // io.sockets
        // .in(bridge_id)
        // .emit("join_broadcast", { status: true, data: [] });
      }

    const users = await audience_list(bridge_id)

      io
      .sockets
      .in(bridge_id)
      .emit("join_broadcast", { status: true, data: users ? users : [] });

      io
      .sockets
      .in(bridge_id)
      .emit("audience_list_update", { status: true, data: users ? users : [] });
    })

    socket.on('audience_list_update',async(req)=>{
      console.log('audience_list_update',req);
      const {bridge_id} = req;
      socket.join(bridge_id);

      const users = await audience_list(bridge_id)
      io
      .sockets
      .in(bridge_id)
      .emit("audience_list_update", { status: true, data: users ? users : [] });

    })


    const complete_booking_broadcast = async (booking_id) => {
      // socket.join(bridge_id);
      const bks = await Booking.findOne({
        where:{
          id:booking_id,
          status:{
            [Op.in]:[0,1,6]
          }
        }
      })

      const dateTime = currentTimeStamp();

      if(bks){
        const update = await Booking.update({
          status:2,
          complete_date:dateTime,
          updated_at:dateTime,
        },{
          where:{
            id:booking_id
          }
        });
        if(update){
          socket.join(bks.bridge_id);
          next_booking(bks.bridge_id)
          delete_broadcast_ant_media(bks.bridge_id,'user'+bks.user_id)
          return true;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }

    socket.on('complete_booking_broadcast',async (req)=>{
      const {user_id,bridge_id,booking_id} = req;
      socket.join(bridge_id);
      await complete_booking_broadcast(booking_id);
      io
      .sockets
      .in(bridge_id)
      .emit("complete_booking_broadcast", { status: true, data: [] });

      connect_status_function(user_id,bridge_id)

      await broadcast_joiners(bridge_id,user_id)

    });

    socket.on('cancel_broadcast_join',async(req)=>{
      const {user_id,bridge_id,booking_id} = req;
      socket.join(bridge_id);
      const dateTime = currentTimeStamp();
      const bks = await Booking.findOne({
        where:{
          id:booking_id,
          status:{
            [Op.in]:[0,1]
          }
        }
      })
      if(bks){

        const t = await sequelize.transaction();
        try {
          const txn_id = 'REFUND'+moment().utc()+user_id;
          var refund_amount = parseFloat(bks.payable_amount);

          await Booking.update({
            status:3,
            refund_txn_id:txn_id,
            updated_at:dateTime,
            cancel_by:2
          },{
            where:{id:bks.id}
          },{
            transaction: t
          })

          // refund_txn_id
          if(refund_amount && parseFloat(refund_amount)){
            const user = await User.findOne({
              where:{
                id:user_id
              }
            })
              var old_wallet = parseFloat(user.wallet);
              var txn_amount =  parseFloat(refund_amount);
              var new_wallet = old_wallet+txn_amount;
              if(new_wallet<0){new_wallet=0}
              var txn_type = 'credit';
              var transactiondata2 = {
                  user_id:user_id,
                  booking_id:booking_id,
                  payment_mode:'wallet',
                  txn_name:"REFUND against ORDERID #"+bks.id+' BROADCAST',
                  booking_txn_id:txn_id,
                  txn_for:'booking',
                  type:txn_type,
                  old_wallet:old_wallet,
                  txn_amount:txn_amount,
                  update_wallet:new_wallet,
                  status:1,
                  created_at:dateTime,
                  updated_at:dateTime
              };
              await User.update({
                  wallet:new_wallet
                  },{
                  where:{
                      id:bks.user_id
                  }
                  },  { transaction: t })
              await Transaction.create(transactiondata2
              , { transaction: t });
          }

          await t.commit();

          io
          .sockets
          .in(bridge_id)
          .emit("cancel_broadcast_join", { status: true, data: bks });
          next_booking(bridge_id)

          connect_status_function(bks.user_id,bridge_id)


          await broadcast_joiners(bridge_id,user_id)
      
        
        }catch(error){
          await t.rollback();

          io
          .sockets
          .in(bridge_id)
          .emit("cancel_broadcast_join", { status: false, data: bks });
        }
      }

    })

    const broadcast_joiners = async (bridge_id,user_id=0) => {
      socket.join(bridge_id);
      const bks = await Booking.scope(['orderAsc']).findAll({
        attributes:['user_id','id','bridge_id','start_time','total_minutes'],
        where:{
          bridge_id:bridge_id,
          status:{
            [Op.in]:[0,1,6]
          }
        }
      })
      .then(async (bookings)=>{
        if(bookings){
          var i=1;
          for (let joiner of bookings) {

            var remaining_time;
          


            if(joiner.start_time && joiner.start_time != ''){
              const time_minutes = parseInt(joiner.total_minutes) ;
              const time_seconds = time_minutes*60;
              const dateTime = moment(currentTimeStamp());
              var a = moment(joiner.start_time);
              var b = moment(dateTime);
              const secondsDiff = Math.abs(a.diff(b, 'seconds'));
              const start_min_seconds = Math.abs(secondsDiff);
              const remaining_time_seconds = time_seconds - start_min_seconds;
              remaining_time=remaining_time_seconds;
            }else{
              remaining_time=broadcast_timeout_time/1000;
            }

            joiner.dataValues.remaining_time = remaining_time

            joiner.dataValues.user = await User.findOne({
              where:{
                id:joiner.user_id
              }
            })
            i++;
          }
        }
        return await bookings;
      })
      // return bks;
      if(bks){
        io
        .sockets
        .in(bridge_id)
        .emit('broadcasters_joiners',{
          status:true,
          data:bks
        })
      }else{
        io
        .sockets
        .in(bridge_id)
        .emit('broadcasters_joiners',{
          status:false,
          data:[]
        })
      }

      // const complete_book = await Booking.scope(['orderDesc']).findOne({
      //     attributes:['user_id'],
      //     where:{
      //       bridge_id:bridge_id,
      //       status:{
      //         [Op.in]:[2]
      //       }
      //     }
      // })
      // if(complete_book){
      //     broadcast_time_expired_user(user_id,complete_book.user_id)
      // }
    }
    socket.on('broadcasters_joiners',async (req)=>{

      const {user_id,astrologer_id,bridge_id} = req;

      await broadcast_joiners(bridge_id,user_id)

      

    })


    const connect_status_function =async (user_id,bridge_id) => {
      var connect_status = 0;
      socket.join(bridge_id);

      await Booking.scope(['orderAsc']).findAll({
        where:{
          bridge_id:bridge_id,
          status:{
            [Op.in]:[0,1,6]
          }
        }
      })
      .then(async(bookings)=>{
        if(bookings){
          var i=1;
          for (let joiner of bookings) {
            if(i==1){
              connect_status=1;
            }

            // if(joiner.user_id == user_id){
            //   connect_status=i;
            // }
            i++;
          }
        }
        return await bookings;
      })

      io
      // .sockets
      // .in(bridge_id)
      .emit("connect_status", { status: true,connect_status, data: {connect_status} });
    }
    
    const connect_status_function_2 =async (user_id,bridge_id) => {
      var connect_status = 0;
      socket.join(bridge_id);

      await Booking.scope(['orderAsc']).findAll({
        where:{
          bridge_id:bridge_id,
          status:{
            [Op.in]:[0,1,6]
          }
        }
      })
      .then(async(bookings)=>{
        if(bookings){
          var i=1;
          for (let joiner of bookings) {
            if(i==1){
              connect_status=1;
            }

            // if(joiner.user_id == user_id){
            //   connect_status=i;
            // }
            i++;
          }
        }
        return await bookings;
      })

      io
      .emit("connect_status", { status: true,connect_status, data: {connect_status} });
    }

    socket.on('connect_status',async (req)=>{
      const {user_id,bridge_id}=req;
      socket.join(bridge_id);

    
    connect_status_function(user_id,bridge_id)
    })

    socket.on('book_broadcast',async (req)=>{
      const {user_id,astrologer_id,total_minutes,amount,bridge_id} = req;
      socket.join(bridge_id);

      // console.log('book_broadcast',req);
      const user = await User.findOne({
        where:{
          id:user_id
        }
      })
      var wallet_deduct = amount;
      const dateTime = currentTimeStamp();

      const check_max_book_queue = await Booking.scope(['astrologer']).count({
        where:{
          bridge_id:bridge_id,
          type:5,
          status:{
            [Op.in]:[0,1,6]
          }
        }
      })
      if(check_max_book_queue <= 3){

        const check_if_user_has_already_booking = await Booking.scope(['astrologer']).count({
          where:{
            user_id:user_id,
            bridge_id:bridge_id,
            type:5,
            status:{
              [Op.in]:[0,1,6]
            }
          }
        })
        if(!check_if_user_has_already_booking){

          const t = await sequelize.transaction();
          try {
      
              const storeData = {
                  user_id,
                  booking_type:2,
                  assign_id:astrologer_id,
                  type:5,
                  subtotal:amount,
                  total_minutes:total_minutes,
                  time_minutes:total_minutes,
                  payable_amount:amount,
                  payment_mode:'wallet',
                  status:0,
                  created_at:dateTime,
                  user_name:user.name,
                  user_gender:user.gender,
                  user_dob:user.dob,
                  user_tob:user.birth_time,
                  user_pob:user.place_of_birth,
                  is_paid:1,
                  bridge_id:bridge_id,
      
              };
              const booking = await Booking.create(storeData
                  , { transaction: t });
                  const bookingInsertID = booking.id;
    
              const txn_id = moment().utc()+user_id+astrologer_id;
              if(wallet_deduct && parseFloat(wallet_deduct)){
                  var old_wallet = parseFloat(user.wallet);
                  var txn_amount =  parseFloat(wallet_deduct);
                  var new_wallet = old_wallet-txn_amount;
                  if(new_wallet<0){new_wallet=0}
                  var txn_type = 'debit';
                  
                  var transactiondata2 = {
                      user_id:user_id,
                      booking_id:bookingInsertID,
                      payment_mode:'wallet',
                      txn_name:"Talk with Astrologer on Broadcast",
                      booking_txn_id:txn_id,
                      txn_for:'booking',
                      type:txn_type,
                      old_wallet:old_wallet,
                      txn_amount:txn_amount,
                      update_wallet:new_wallet,
                      status:1,
                      created_at:dateTime,
                      updated_at:dateTime
                  };
                  await User.update({
                      wallet:new_wallet
                      },{
                      where:{
                          id:user_id
                      }
                      },  { transaction: t })
                  await Transaction.create(transactiondata2
                  , { transaction: t });
              }
            
              await t.commit();
              Booking.update({
                txn_id:txn_id
              },{
                where:{
                  id:bookingInsertID
                }
              })
              set_astrologer_comission_to_order(bookingInsertID)
              io
              .sockets
              .in(bridge_id)
              .emit('book_broadcast',{
                status:true,
                data:booking
              })

              if(!check_max_book_queue){
                // const newtime = currentTimeStamp();

              
                complete_broadcast_booking_by_interval(bookingInsertID);

              }

    
          }catch (error) {
              // If the execution reaches this line, an error was thrown.
              // We rollback the transaction.
              await t.rollback();
      
              io
              .sockets
              .in(bridge_id)
              .emit('book_broadcast',{
                status:false,
                data:[]
              })
          }
        }else{

        }

      }
      else{
        io
        .sockets
        .in(bridge_id)
        .emit('book_broadcast',{
          status:false,
          data:[]
        })
      }
      connect_status_function(user_id,bridge_id)

      await broadcast_joiners(bridge_id,user_id)

    

    })

    // cons

    const complete_broadcast_booking_by_interval = async (booking_id) => {
      // console.log('interval FIRE',booking_id);
      const newtime = currentTimeStamp();
      if(broadcast_joiners_timeout){
        clearTimeout(broadcast_joiners_timeout)
      }
      await Booking.update({
        start_time:newtime,
        schedule_date_time:newtime,
        status:6
      },{
        where:{
          id:booking_id
        }
      })

      broadcast_joiners_timeout= setTimeout(async () => {
        const dateTime = currentTimeStamp();
        const booking =await Booking.update({
          status:2,
          end_time:dateTime,
          updated_at:dateTime
        },{
          where:{
            id:booking_id
          }
        })

        const booking2 = await Booking.findOne({
          where:{
            id:booking_id
          }
        })

        delete_broadcast_ant_media(booking2.bridge_id,'user'+booking2.user_id)

        socket.join(booking2.bridge_id);

        /**next timeout */
        next_booking(booking2.bridge_id)
        
        /** */

        if(booking2){
          connect_status_function_2(booking2.user_id,booking2.bridge_id)

          broadcast_joiners(booking2.bridge_id,booking2.user_id)
          // connect_status_function(booking.user_id,booking.bridge_id)
        }


      }, broadcast_timeout_time);
    
    }

    create_broadcast_event = () => io.emit('create_broadcast',{status:true,message:'new'})


    const next_booking = async (bridge_id) => {
      /**next timeout */
      socket.join(bridge_id);

      const nextbooking = await Booking.scope(['orderAsc']).findOne({
        where:{
          bridge_id:bridge_id,
          status:{
            [Op.in]:[0,1]
          }
        }
      })
      if(nextbooking){
        complete_broadcast_booking_by_interval(nextbooking.id)
      }
      
      /** */
    }



    socket.on('reject_request',async (req)=>{
      console.log('reject request');
      const {user_id,bridge_id} = req;
      const dt = await Bookingrequest.findOne({
        where: {
          user_id: user_id,
        },
        order:[['id','desc']]
      });

      socket.join(user_id)


      await Bookingrequest.destroy({
        where: {
          user_id: user_id,
          status: 0,
        },
      });
      if(dt){
        astro_dynamic_func(dt.astrologer_id)

      }
      if (dt.status == 0) {

        // const data = await booking_status_function(dt.user_id);
        // io.sockets.in(user_id).emit("get_booking_status", data);
        await booking_status_event_emit(user_id)

      }
    })


    socket.on('astrologers_dynamic',async (req)=>{
      const {astrologer_id} = req;
      socket.join('astro'+astrologer_id);
      return astro_dynamic_func(astrologer_id)
      
    })

    socket.on('gift_sender_user',async (req)=>{
      const { bridge_id } = req;
      socket.join(bridge_id);
      io.sockets.in(bridge_id).emit('gift_sender_user',{
        status:false,
        data:[]
      })
    })


    /**send gift */
    socket.on('send_gift',async req=>{
      const {user_id,broadcast_id,gift_id,bridge_id} = await get_json(req);
      socket.join(bridge_id);
      const dt = await send_gifts_function(user_id,broadcast_id,gift_id);
      io.sockets.in(bridge_id).emit('send_gift',dt);
      io.sockets.in(bridge_id).emit('gift_sender_user',dt);

      const bds = await Broadcast.findOne({
          where:{
              id:broadcast_id
          }
      })
      if(bds){
          return astro_bag_pack(bds.astrologer_id,broadcast_id)
      }

    })

    socket.on('user_queue',async req => {
      const {user_id} =  req;
      socket.join(user_id)
      await user_queue(user_id)
    })

    const user_queue = async (user_id) => {
      const data =await fetch_user_queue_fun(user_id);
      socket.join(user_id)
      io.sockets.in(user_id).emit('user_queue',data);

    }

    socket.on('astrologer_bag_pack', async req => {
        const {astrologer_id,broadcast_id} = req;
        return await astro_bag_pack(astrologer_id,broadcast_id);
    })

    const astro_bag_pack = async (astrologer_id,broadcast_id) => {
      const data =await astrologer_bag_pack(astrologer_id,broadcast_id);
      socket.join(astrologer_id)
      io.sockets.in(astrologer_id).emit('astrologer_bag_pack',data);

    }



    const astro_dynamic_func =async (astrologer_id) => {
      socket.join('astro'+astrologer_id);
      const data = await astrologer_dynamic_function(astrologer_id);
      io.sockets.in('astro'+astrologer_id).emit('astrologers_dynamic',data);
    }

    socket.on('broadcast_time_expired_user',async (req)=>{
      const {user_id} = req;
      const booking_user_id = 0;
      broadcast_time_expired_user(user_id,booking_user_id)
    })

    const broadcast_time_expired_user = (user_id,booking_user_id) => {
      socket.join(user_id);

      if(user_id == booking_user_id){
        io.sockets.in(user_id).emit('broadcast_time_expired_user',{
          status:true,
          message:'yes'
        })
      }else{
        io.sockets.in(user_id).emit('broadcast_time_expired_user',{
          status:false,
          message:'no'
        })
      }

    }

    
    // const 

    // socket.on('accept_by_user',);
  });


}
// const PORT = 3355;

// http.listen(PORT, () => {
//   console.log(`listening on *:${PORT}`);
// });
