const { successRes, failedRes } = require("../helpers/response.helper");
const { Op } = require('sequelize')
const moment = require("moment");
const { sequelize, Speciality,Transaction, Skill, Notification, God, Temple, Booking, Bookinghistory, Priest, Supervisor, DateWise, Bookingrequest, FAQ, Support, Language, Broadcast, Follower, Member, Gift, SendGift, Astrologer, User, BookBroadcast } = require("../models/index");
const { send_booking_complete_notification } = require("../helpers/notification.helper");
const { currentTimeStamp } = require("../helpers/user.helper");

const nodeschedule = require('node-schedule');

// const { create_broadcast_event } = require("../socket/socket");

const fetch_gifts = async (req,res) => {
    const gifts = await Gift.scope(['active']).findAll();
    res.json(successRes('fetched',gifts))
}

const fetch_languages = async (req,res) => {
    const languages = await Language.findAll();
    res.json(successRes('fetched',languages))

}

const fetch_astrologer_broadcasts = async (req,res) => {
    const {astrologer_id} = req.body;
    const broadcasts = await Broadcast.findAll({
        where:{
            status:{
                [Op.ne] : [2]
            },
            astrologer_id:astrologer_id
        },
        order:[['id','desc']]
    })
    res.json(successRes('fetched',broadcasts))
}

const update_broadcast_gifts = async (req,res) => {
    const {astrologer_id,broadcast_id,gifts_id} = req.body;
    const broadcast = await Broadcast.update({
        gifts_id
    },{
        where:{
            status:{
                [Op.ne] : [2]
            },
            astrologer_id:astrologer_id,
            id:broadcast_id
        }
    })
    res.json(broadcast?successRes('success',broadcast):failedRes('something went wrong'))
}


const delete_broadcast = async (req,res) => {
    const {astrologer_id,broadcast_id} = req.body;
    const deletebrd = await Broadcast.destroy({
        where:{
            astrologer_id,
            id:broadcast_id
        }
    },{
        where:{
            status:{
                [Op.ne] : [2]
            },
            astrologer_id:astrologer_id,
            id:broadcast_id
        }
    })
    res.json(deletebrd?successRes('success',deletebrd):failedRes('something went wrong'))
}


const start_broadcast_astro = async (req,res) => {
    const {astrologer_id,broadcast_id} = req.body;
    const broadcast = await Broadcast.findOne({
        where:{
            status:{
                [Op.ne] : [2]
            },
            astrologer_id:astrologer_id,
            id:broadcast_id
        }
    })
    const dateTime = currentTimeStamp();
    if(broadcast){
        var a = moment(broadcast.start_time);
        var b = moment(broadcast.end_time);
        var diffinseconds = Math.abs(a.diff(b, 'seconds'));
        var diffinminutes= Math.abs(a.diff(b, 'minutes'));
        const updateData = {
            status:1,
            total_minutes:diffinminutes,
            total_seconds:diffinseconds
        }
        const upd = await Broadcast.update(updateData,{
            where:{
                id:broadcast.id
            }
        })
        if(upd){
            res.json(successRes('success',upd))
        }else{
            res.json(failedRes('failed',upd))
        }
    }else{
        res.json(failedRes('failed',null))
    }

    // var a = moment(check.start_time);

    // var b = moment(dateTime)
    // var diffinseconds = Math.abs(a.diff(b, 'seconds'));
    // var diffinminutes= Math.abs(a.diff(b, 'minutes'));

    // const updateData = {
    //   status:2,
    //   end_time:dateTime,
    //   total_minutes:diffinminutes,
    //   total_seconds:diffinseconds
    // }
}

const end_broadcast_by_timeout = async (broadcast_id) => {
    const broadcast = await Broadcast.findOne({
        where:{
            status:{
                [Op.ne] : [2]
            },
            astrologer_id:astrologer_id,
            id:broadcast_id
        }
    })
    if(broadcast){
        const upd = await Broadcast.update({
            status:2
        },{
            where:{
                id:broadcast.id
            }
        })
        return true;
    }else{
        return false;
    }
}

const fetch_gift_bag = async (req,res) => {
    const {astrologer_id,broadcast_id} = req.body;
    const fetchdata = await SendGift.findAll({
        where:{
            astrologer_id:astrologer_id,
            broadcast_id:broadcast_id
        }
    })
    const countamount = await SendGift.findOne({
        where:{
            astrologer_id:astrologer_id,
            broadcast_id:broadcast_id
        },
        attributes: [[sequelize.fn('sum', sequelize.col('price')), 'total']],
    })
    res.json({
        status:true,
        countamount:countamount,
        data:fetchdata
    })

}


const fetch_broadcast_customer = async (req,res) => {
    const {user_id} = req.body;
    const broadcasts = await Broadcast.scope(['approved','pending_start','orderAsc']).findAll().then(async(bds)=>{
        for (let bd of bds) {
            bd.dataValues.astrologer = await Astrologer.findOne({
                where:{
                    id:bd.astrologer_id
                }
            })
            bd.dataValues.is_booked = await checkIfBroadcastBook(user_id,bd.id) ? 1 : 0
            bd.dataValues.total_bookings = await countBookeedPeople(bd.id)
        }
        return await bds;
    });
    res.json(successRes('fetched',broadcasts))
}

const countBookeedPeople = async (broadcast_id) => {
    const cd = await BookBroadcast.count({
        where:{
            broadcast_id
        }
    })
    return cd ? cd : 0;
}
const checkIfBroadcastBook = async (user_id,broadcast_id) => {
    const data = await BookBroadcast.findOne({
        where:{
            user_id,
            broadcast_id
        }
    });
    return data;
}
const book_broadcast = async (req,res) => {
    // console.log('book_broadcast',req.body);
    const {user_id,broadcast_id} = req.body;
    const user = await User.findOne({where:{id:user_id}})
    const broadcast = await Broadcast.scope(['approved','pending_start','orderAsc']).findOne({
       where:{ id:broadcast_id }
    });
    if(broadcast && user){
        const checkIfAlreadyBooked = await checkIfBroadcastBook(user_id,broadcast.id);
        if(checkIfAlreadyBooked){
            return res.json(failedRes('already Booked'))

        }else{
            const paid_amount =parseFloat(broadcast.price);
            const wallet = parseFloat(user.wallet);
            if(wallet >= paid_amount){
                const new_wallet = wallet - paid_amount;
    
                var txn_type = 'debit';
                const dateTime = currentTimeStamp();
                const txn_id = 'BD'+moment().utc();
                var transactiondata = {
                    user_id:user_id,
                    txn_name:'Deduction against '+broadcast.title,
                    payment_mode:'wallet',
                    booking_txn_id:txn_id,
                    txn_for:'wallet',
                    type:txn_type,
                    old_wallet:wallet,
                    txn_amount:paid_amount,
                    update_wallet:new_wallet,
                    status:1,
                    created_at:dateTime,
                    updated_at:dateTime,
                };
                const t = await sequelize.transaction();
                try {
                    await User.update({
                        wallet:new_wallet
                    },{
                        where:{
                        id:user_id
                        }
                    },  { transaction: t })
                    const dt = await Transaction.create(transactiondata
                        , { transaction: t })
    
                    const bookdata = {
                        user_id,
                        astrologer_id:broadcast.astrologer_id,
                        broadcast_id:broadcast.id,
                        price:paid_amount,
                        txn_id,
                        created_at:dateTime
                    }
                    const storedata = await BookBroadcast.create(bookdata,{
                        transaction: t
                    })
                    await t.commit();
                    return res.json(successRes('done!!',dt))
                }catch (error) {
                    // If the execution reaches this line, an error was thrown.
                    // We rollback the transaction.
                    await t.rollback();
                    return res.json(failedRes('failed!!',error));
                }
            }else{
                return res.json(failedRes('Insufficient Balance!!'));
            }
        }
       
    }else{
        return res.json(failedRes('failed!!'));

    }

}

const fetch_broadcast_gifts = async (req,res) => {
    const {user_id,broadcast_id} = req.body;
    const broadcast = await Broadcast.scope(['approved','start']).findOne({
        where:{
            id:broadcast_id
        }
    });
    if(broadcast){
        const giftId = broadcast.gifts_id ? broadcast.gifts_id  : 0;
        var ids_arr = [];
        if(giftId){
             ids_arr = giftId.split(",");

        }
        const gifts = await Gift.scope(['active']).findAll({
            where:{
                id:{
                    [Op.in]:ids_arr
                }
            }
        });
        res.json(successRes('fetched',gifts))
    }else{
        res.json(failedRes('Broadcast Not Started Yet...'))
    }
}

const schedule_event = async (req,res) => {

    // const momenttime = currentTimeStamp();

    // const rule = new nodeschedule.RecurrenceRule();

    // const schedule_arr = momenttime.split(" ");
    // const schedule_date_month_year = schedule_arr[0].split("-");
    // const schedule_time = schedule_arr[1].split(":");

    // rule.date=schedule_date_month_year[2]
    // rule.month=schedule_date_month_year[1]
    // rule.year=schedule_date_month_year[0]
    // rule.hour = schedule_time[0];
    // rule.minute = schedule_time[1];
    // rule.second = schedule_time[2];
    // rule.tz = 'Asia/Calcutta';

    // const rule = new nodeschedule.RecurrenceRule();
    // rule.hour = 15;
    // rule.minute = 32;
    // rule.tz = 'Asia/Calcutta';

    const momenttime = currentTimeStamp();

    const rule = new nodeschedule.RecurrenceRule();

    const schedule_arr = momenttime.split(" ");
    const schedule_date_month_year = schedule_arr[0].split("-");
    const schedule_time = schedule_arr[1].split(":");

    // rule.date= parseInt(schedule_date_month_year[2])
    // rule.month=parseInt(schedule_date_month_year[1])
    // rule.year=parseInt(schedule_date_month_year[0])
    // rule.hour = 17;
    // rule.minute = 4;
    // rule.second = schedule_time[2];

    rule.date= parseInt(schedule_date_month_year[2])
    rule.month=parseInt(schedule_date_month_year[1])-1
    rule.year=parseInt(schedule_date_month_year[0])
    rule.hour = parseInt(schedule_time[0]);
    rule.minute = parseInt(schedule_time[1])+1;
    // rule.dayOfWeek=2
    // rule.second = schedule_time[2];
    rule.tz = 'Asia/Calcutta';
    // console.log(rule);

    const job = nodeschedule.scheduleJob(rule, function(){
    console.log('The answer to life, the universe, and everything!');
    });
    // console.log('job',job);


    res.json(successRes(''))

    // const arr1 = [2,4,3];
    // const arr2 = [5,6,4];
    // const output = [7,0,8];

}

// const gift_sender_details = async (id) => {
//     const gift = await SendGift.findOne({
//         where:{
//             id:id
//         }
//     })
//     if(gift){

//     }
// }

const send_gifts_function = async (user_id,broadcast_id,gift_id) => {
    // const {user_id,broadcast_id,gift_id} = req.body;
    const broadcast = await Broadcast.scope(['approved','start']).findOne({
        where:{
            id:broadcast_id
        }
    });
    const user = await User.findOne({
        where:{
            id:user_id
        }
    })
    const gift = await Gift.findOne({
        where:{
            id:gift_id
        }
    })
    if(broadcast){
        const astrologer_id = broadcast.astrologer_id;
        const price = parseFloat(gift.price);
        const paid_amount = parseFloat(gift.price);

        const wallet = parseFloat(user.wallet);
        if(wallet >= price){
            const new_wallet = wallet - paid_amount;

            var txn_type = 'debit';
            const dateTime = currentTimeStamp();
            const txn_id = 'gift'+moment().utc();
            var transactiondata = {
                user_id:user_id,
                txn_name:'Deduction against '+broadcast.title+' Gift : '+gift.name.toUpperCase(),
                payment_mode:'wallet',
                booking_txn_id:txn_id,
                txn_for:'wallet',
                type:txn_type,
                old_wallet:wallet,
                txn_amount:paid_amount,
                update_wallet:new_wallet,
                status:1,
                created_at:dateTime,
                updated_at:dateTime,
            };
    
            const storeData = {
                user_id:user_id,
                broadcast_id:broadcast.id,
                astrologer_id:astrologer_id,
                user_name:user.name,
                user_image:user.imageUrl,
                gift_id:gift.id,
                gift_name:gift.name,
                price:price,
                txn_id:txn_id,
                created_at:dateTime,
            }
    
            const t = await sequelize.transaction();
            try {
                await User.update({
                    wallet:new_wallet
                },{
                    where:{
                    id:user_id
                    }
                },  { transaction: t })
                const dt = await Transaction.create(transactiondata
                    , { transaction: t });
    
    
                var storedata = await SendGift.create(storeData,{
                    transaction: t
                })
                await t.commit();
                storedata.dataValues.gift_image = gift.imageUrl;
                return successRes('done!!',storedata)
            }catch (error) {
                // If the execution reaches this line, an error was thrown.
                // We rollback the transaction.
                await t.rollback();
                return failedRes('failed!!',error);
            }
        }else{
            return failedRes('Insufficient Balance!!',error);

        }
       
    }else{
        return failedRes('failed!!',null);

    }
}

const send_gifts = async (req,res) => {
    const {user_id,broadcast_id,gift_id} = req.body;
    const jsondata = await send_gifts_function(user_id,broadcast_id,gift_id);
    res.json(jsondata)
}

const astrologer_bag_pack = async (astrologer_id,broadcast_id) => {
    const resdata = await SendGift.findOne({
        where:{
            astrologer_id:astrologer_id,
            broadcast_id:broadcast_id
        },
        attributes: [[sequelize.fn('sum', sequelize.col('price')), 'total_price']],
    })
    return successRes('',resdata);
}



// const 
module.exports = {
    fetch_gifts,
    fetch_languages,
    fetch_astrologer_broadcasts,
    update_broadcast_gifts,
    delete_broadcast,
    start_broadcast_astro,
    end_broadcast_by_timeout,
    fetch_gift_bag,
    fetch_broadcast_customer,
    book_broadcast,
    fetch_broadcast_gifts,
    schedule_event,
    send_gifts_function,
    send_gifts,
    astrologer_bag_pack
}