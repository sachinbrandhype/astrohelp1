const { successRes, failedRes } = require("../helpers/response.helper");
const db = require("../models/index");
const { User, Cart, Puja} = db;
const { Op } = require('sequelize')
const moment = require("moment");
const { Member, Guest, Booking, Bookinghistory, sequelize, Coupon, Couponapply, Pujalocation, Venue, City, Astrologer, Kundalimatchuser, Transaction, Ledgercode, Broadcastjoin, Skill, Speciality, CancellationReason, AstrologerDiscount } = require("../models/index");
const { addTransaction, currentTimeStamp } = require("../helpers/user.helper");
const { imagePaths } = require("../config/app.config");
const { send_fcm_push, horoscope_book_notification } = require("../helpers/notification.helper");
const { send_schedule_notification } = require("../helpers/schedulenotification.helper");
const { set_astrologer_comission_to_order } = require("./home.controller");
const { call_reminder_ivr } = require("../helpers/ivr.helper");

const roundno = (no) => Math.round(no);

const GST_PERCT = 18;

const GenerateUniqueID = function () {
    // Math.random should be unique because of its seeding algorithm.
    // Convert it to base 36 (numbers + letters), and grab the first 9 characters
    // after the decimal.
    return  Math.random().toString(36).substr(2, 9);
};


const fetch_payable_amount_puja =async (req,res) =>{
    const {user_id,puja_id}=req.body;
    var discount=0;
    var price=0;
    var coupon={};

    const puja =await Puja.findOne({
        where:{
            id:puja_id
        }
    }).then(rs=>rs);
    if(!puja){return res.json(failedRes('not found',puja))}

    const member =await Member.findOne({
        order:[
            ['id','desc']
        ],
        where:{
            user_id:user_id
        }
    }).then((rs)=>rs);


    const guests =await Guest.findOne({
        order:[
            ['id','desc']
        ],
        where:{
            user_id:user_id
        }
    }).then((rs)=>rs);
    var total = 0;

    // var discount_type = puja.discount_type;
    var price = puja.price;
    // if(discount_type==2){
    //     var pujadiscount = roundno(price*(2/100));
    //     price -= pujadiscount;
    // }
    // if(price<0){
    //     price=0;
    // }
    var subtotal = parseFloat(price);
    total += subtotal;

    const couponapply =await Couponapply.findOne({
        order:[
            ['id','desc']
        ],
        where:{
            user_id:user_id
        }
    }).then(async (rs)=>{
        if(rs){
            const cop= await Coupon.scope(['active','puja']).findOne({where:{id:rs.coupon_id}}).then((cp)=>cp);
            var copdiscount=0;
            if(cop.discount_type =='flat'){
                 copdiscount = roundno(parseFloat(cop.amount));
            }else{
                copdiscount =roundno(subtotal*(parseFloat(cop.amount)/100))
            }
            // subtotal -= copdiscount;
            discount=copdiscount;
            // if(subtotal<0){subtotal=0;}
            return await cop;
        }
    });


    // var gst = roundno(price*(18/100));
    var gst = 0;

    // price += gst;

    total = subtotal - discount;
    if(total <0){total=0}

    return res.json({
        status:true,
        message:'',
        puja:puja,
        host:member,
        coupon:couponapply,
        guests:guests,
        subtotal:subtotal,
        discount:discount,
        gst:gst,
        total:total
    })


}

// const base64Encode = text => {
//     const base64data = Uti.base64Encode(text, Utilities.Charset.UTF_8);
//     return base64data;
//   };


const booking_puja = async (req,res) => {
    var {
        user_id,
        puja_id,
        guests,
        subtotal,
        donation,
        discount,
        gst,
        total,
        schedule_date,
        schedule_time,
        venue,
        location,
        main_location_id,
        location_id,
        venue_id,
        txn_id,
        wallet_deduct,
        payment_mode
    } = req.body;
    // console.log(req.body);
    const dateTime = await currentTimeStamp();;
    const puja =await Puja.findOne({
        where:{
            id:puja_id
        }
    }).then(rs=>rs);
    if(!puja){return res.json(failedRes('not found',puja))}
    const user =await User.findOne({where:{
        id:user_id
    }})

    const ledger =await Ledgercode.findOne({
        where:{
            id:puja.ledger_code_id
        }
    })
    var tax_name = ledger ? ledger.ledger_name : '';
    var tax_percentage = puja.tax_percentage;

    const couponapply =await Couponapply.findOne({
        order:[
            ['id','desc']
        ],
        where:{
            user_id:user_id
        }
    }).then(async (rs)=>{
        if(rs){
            const cop= await Coupon.scope(['active','puja']).findOne({where:{id:rs.coupon_id}}).then((cp)=>cp);
            // var copdiscount=0;
            // if(cop.discount_type =='flat'){
            //      copdiscount = roundno(parseFloat(cop.amount));
            // }else{
            //     copdiscount =roundno(subtotal*(parseFloat(cop.amount)/100))
            // }
            // // subtotal -= copdiscount;
            // discount=copdiscount;
            // // if(subtotal<0){subtotal=0;}
            return await cop;
        }
    });
    var coupon_id = couponapply ? couponapply.id : 0 ;

    var member =await Member.scope(['active']).findOne({
        order:[
            ['id','desc']
        ],
        where:{
            user_id:user_id,
        }
    }).then((rs)=>rs);

    // var member = null;

    if(!member){
        member={
            type:'host',
            name:user.name,
            dob:user.dob,
            tob:user.birth_time,
            pob:user.place_of_birth,
            mothername:user.mother_name,
            fathername:user.father_name,
            gotro:user.gotro,
            spouse:user.spouse_name,
            id:0,
        };
    }

    var price = roundno(puja.price);
    // var discount_type = puja.discount_type;
    // if(discount_type==2){
    //     var pujadiscount = roundno(price*(2/100));
    //     price -= pujadiscount;
    // }
    // if(price<0){
    //     price=0;
    // }
    const format1 = "YYYY-MM-DD HH:mm:ss"
    var sh_dt = moment(schedule_time, ["hh:mmA"]).format("HH:mm")
    var date1 = new Date(schedule_date+' '+sh_dt);
    const dateTime1 = moment(date1).format(format1);

  

    if(venue_id){

        await Pujalocation.findOne({
            where : {
                puja_id:puja_id,
                location_id:location_id
            }
        }).then((rs)=>{
            main_location_id=rs.id
        })

        await Venue.findOne({
            where:{
                id:venue_id
            }
        }).then(async (rs)=>{
            if(rs){
                venue=rs.name
            }
        })

        await City.findOne({
            where:{
                id:location_id
            }
        }).then(async (rs)=>{
            if(rs){
                location=rs.name
            }
        })
    }
    
    const pmode = payment_mode ? payment_mode : 'online';
    var payableAmt = parseFloat(total)+parseFloat(donation ? donation : 0);

    const t = await sequelize.transaction();
    try {
        const storeData = {
            user_id,
            orderID:'SH'+moment().utc()+user_id,
            booking_type:1,
            subtotal,
            discount,
            gst	,
            donation,
            coupon_id,
            schedule_date,
            schedule_time,
            payable_amount:payableAmt,
            payment_mode:pmode,
            status:0,
            txn_id:txn_id,
            is_paid:1,
            created_at:dateTime
        };
        const booking = await Booking.create(storeData
            , { transaction: t });
        const bookingInsertID = booking.id;
        // console.log('booking id',bookingInsertID);
        
        if(pmode=='online'){
            const transactiondata = {
                booking_id:bookingInsertID,
                booking_txn_id:txn_id,
                txn_for:'booking',
                payment_mode:pmode,
                txn_amount:payableAmt,
                type:'debit',
                status:1,
                user_id:user_id,
                created_at:dateTime,
                updated_at:dateTime
            }
            await Transaction.create(transactiondata
                , { transaction: t });
        }
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
      

        const storeBookingHistory = {
            user_id,
            mode : puja.pooja_type==2?'ground':'online',
            booking_id:bookingInsertID,
            suborderID:'SHP'+moment().utc()+user_id,
            bridge_id:GenerateUniqueID()+moment().utc(),
            puja_id:puja_id,
            name:puja.name,
            tax_breakup:puja.price_breakup ,
            amount:price,
            host_type:member.type,
            host_name:member.name,
            host_dob:member.dob,
            host_tob:member.tob,
            host_pob:member.pob,
            host_mothername:member.mothername,
            host_fathername:member.fathername,
            host_gotro:member.gotro,
            host_spouse:member.spouse,
            member_id:member.id,
            guests,
            schedule_date,
            schedule_time,
            schedule_date_time:dateTime1,
            created_at:dateTime,
            booking_location:location,
            venue,
            main_location_id,
            location_id,
            tax_name,
            tax_percentage,
            discount_amount:puja.discount_price ? puja.discount_price  : 0,
            tax_amount:puja.tax_price
        }
        
         await Bookinghistory.create(storeBookingHistory
            , { transaction: t });

        await Couponapply.destroy({
            where : {user_id:user_id}
        }
        , { transaction: t });
    
        // // If the execution reaches this line, no errors were thrown.
        // // We commit the transaction.
        await t.commit();

        const currentdateTime = moment(await currentTimeStamp()).add('5.49','hours').utc();
        var a = moment(dateTime1,'YYYY-MM-DD HH:ssa');
        var b = moment(currentdateTime)
        var diffseconds = Math.abs(a.diff(b, 'seconds'));
        
        setTimeout(() => {
            send_fcm_push(user.device_token,"Puja Start","Hi "+user.name.toUpperCase()+",Your booking for puja "+puja.name.toUpperCase()+" is start",req.body,"High");
        }, diffseconds*1000);


        const inurl = imagePaths.invoiceURL+bookingInsertID;

        const title = "Booking Successful";
        const msg = "Hi "+user.name.toUpperCase()+",Your booking for puja "+puja.name.toUpperCase()+" is successfull. Your Schedule Date & Time is "+dateTime1;
        send_fcm_push(user.device_token,title,msg,req.body);
        // send_schedule_notification(dateTime1,'Your puja is start', "Hi "+user.name.toUpperCase()+",Your booking for puja "+puja.name.toUpperCase()+" is started. Please Join, Thankyou!",req.body);
        return res.json({
            status:true,
            invoice:inurl,
            share_url:'http://139.59.25.187/pooja-details/'+puja_id,
            data:booking,


        })
    
    } catch (error) {
    
        // If the execution reaches this line, an error was thrown.
        // We rollback the transaction.
        await t.rollback();

        return res.json(failedRes('failed!!'))
    
    }
    
}



const fetch_puja_coupons = async (req,res) => {
    const {user_id}=req.body;
    // console.log('come');
    const couponlist=await Coupon.scope(['active','puja']).findAll().then(async (coupons)=>{
        var new_arr=[]
        for (let cp of coupons) {
            // if(moment(cp.start_date).isAfter('2010-01-01', 'year'))
            // console.log('date',moment(cp.start_date, "YYYY-MM-DD"));
            const start_date = moment(cp.start_date, "YYYY-MM-DD");
            const expiry_date = moment(cp.expiry_date, "YYYY-MM-DD");
            const currentdate = moment().format();;

            if(moment(currentdate).isSameOrAfter(start_date) && moment(currentdate).isSameOrBefore(expiry_date)){
                new_arr.push(cp);

            }
        }
        return new_arr;
    });
    return res.json(successRes('',couponlist));
}



const fetch_horoscope_coupons = async (req,res) => {
    const {user_id}=req.body;
    // console.log('come');
    const couponlist=await Coupon.scope(['active','horoscope']).findAll().then(async (coupons)=>{
        var new_arr=[]
        for (let cp of coupons) {
            // if(moment(cp.start_date).isAfter('2010-01-01', 'year'))
            // console.log('date',moment(cp.start_date, "YYYY-MM-DD"));
            const start_date = moment(cp.start_date, "YYYY-MM-DD");
            const expiry_date = moment(cp.expiry_date, "YYYY-MM-DD");
            const currentdate = moment().format();;

            if(moment(currentdate).isSameOrAfter(start_date) && moment(currentdate).isSameOrBefore(expiry_date)){
                new_arr.push(cp);

            }
        }
        return new_arr;
    });
    return res.json(successRes('',couponlist));
}


const fetch_astrologer_coupons = async (req,res) => {
    const {user_id}=req.body;
    // console.log('come');
    const couponlist=await Coupon.scope(['active','astrologer']).findAll().then(async (coupons)=>{
        var new_arr=[]
        for (let cp of coupons) {
            // if(moment(cp.start_date).isAfter('2010-01-01', 'year'))
            // console.log('date',moment(cp.start_date, "YYYY-MM-DD"));
            const start_date = moment(cp.start_date, "YYYY-MM-DD");
            const expiry_date = moment(cp.expiry_date, "YYYY-MM-DD");
            const currentdate = moment().format();;

            if(moment(currentdate).isSameOrAfter(start_date) && moment(currentdate).isSameOrBefore(expiry_date)){
                new_arr.push(cp);

            }
        }
        return new_arr;
    });
    return res.json(successRes('',couponlist));
}


const apply_coupon =async (req,res)=>{
    const {user_id,coupon_id}=req.body;
    const dateTime =await currentTimeStamp();
    await Couponapply.findOne({
        where:{
            user_id:user_id,
            coupon_id:coupon_id
        }
    }).then((rs)=>{
        if(rs){
            return res.json(successRes('applied',rs))
        }
    })
    const storedata = {
        user_id,
        coupon_id,
        created_at:dateTime
    }
    await Couponapply.create(storedata).then((applied)=>{
        return res.json(successRes('applied',applied))
    })
    .catch((err=>res.json('failed',err)))

}


const remove_coupon =async (req,res)=>{
    const {user_id}=req.body;
    await Couponapply.destroy({
        where:{
            user_id:user_id,
        }
    }).then((rs)=>{
        if(rs){
            return res.json(successRes('removed',rs))
        }
    })
  
}

const puja_booking_history = async (req,res) => {
    const {user_id,limit,offset}=req.body;

    const booking = await Booking.scope(['puja','orderDesc']).findAll({
        limit:parseInt(limit),
        offset:parseInt(offset),
        where:{
            user_id:user_id
        },
        attributes:['id','orderID','mode','subtotal','discount','gst','donation','payable_amount','coupon_code','booking_for','txn_id','status']
    }).then(async (bookings)=>{
        for (let booking of bookings) {
            const bh =await Bookinghistory.findAll({
                where:{
                    booking_id:booking.id
                }
            })
            const inurl = "http://139.59.25.187/shaktipeeth_new/Booking_management/invoice_genrate/"+booking.id;
            booking.dataValues.invoice=inurl;
            booking.dataValues.pujas=bh;
        }
        return await bookings
    })

    return res.json(successRes('fetched',booking))
}



const fetch_payable_amount_horoscope =async (req,res) =>{
    const {user_id,astrologer_id}=req.body;
    var total = 0;
    const user = await User.findOne({
        where:{
            id:user_id
        }
    })
    const astrologer =await Astrologer.findOne({
        where:{
            id:astrologer_id
        }
    });

    var member =await Member.scope(['active']).findOne({
        order:[['id','desc']],
        where:{
            user_id:user_id
        }
    })
    if(!member){
        member={
            type:'host',
            name:user.name,
            dob:user.dob,
            tob:user.birth_time,
            pob:user.place_of_birth,
            mothername:user.mother_name,
            fathername:user.father_name,
            gotro:user.gotro,
            spouse:user.spouse_name,
            language:language,
            message:'',
            id:0,
        };
    }

    var price = roundno(astrologer.horoscope_price);
    var subtotal = parseFloat(price);

    const wallet_balance = parseFloat(user.wallet);

    var wallet_deduct = 0;

    if(wallet_balance >= price){
        wallet_deduct = price
        total += price - wallet_deduct
    }else{
        wallet_deduct = wallet_balance;

        total += price - wallet_deduct;
    }

    var gst_pct = GST_PERCT;

    const gst_amount = Math.round(total*(gst_pct/100));

    const remain_after = total;

    total += gst_amount
    if(total <0){total=0}

    return res.json({
        status:true,
        message:'',
        // astrologer,
        member:member,
        subtotal:subtotal,
        wallet_balance,
        wallet_deduct:wallet_deduct,
        remain_after,
        gst_perct:gst_pct,
        gst_amount,
        total:total
    })
}

const bill_payable_amount_horoscope = async(user_id,astrologer_id,skill_id) => {
    var total = 0;
    const user = await User.findOne({
        where:{
            id:user_id
        }
    })
    const astrologer =await Astrologer.findOne({
        where:{
            id:astrologer_id
        }
    });

    var member =await Member.scope(['active']).findOne({
        order:[['id','desc']],
        where:{
            user_id:user_id
        }
    })
    if(!member){
        member={
            type:'host',
            name:user.name,
            dob:user.dob,
            tob:user.birth_time,
            pob:user.place_of_birth,
            mothername:user.mother_name,
            fathername:user.father_name,
            gotro:user.gotro,
            spouse:user.spouse_name,
            language:language,
            message:'',
            id:0,
        };
    }
    var price = roundno(astrologer.horoscope_price);
    var horoscope_name=''
    if(skill_id && skill_id !=''){

        const skill = await Skill.findOne({
            where:{
                id:skill_id
            }
        })
        if(skill){
            price = skill.horoscope_price;
        }

        const speciality =await Speciality.findOne({
            where:{
                id:skill.speciality_id
            }
        })
        horoscope_name=speciality.name;

    }

    var subtotal = parseFloat(price);

    const wallet_balance = parseFloat(user.wallet);

    var wallet_deduct = 0;
    var payment_total=0;
   

    if(wallet_balance >= price){
        wallet_deduct = price
        total += price - wallet_deduct;
    }else{
        wallet_deduct = wallet_balance;
        total += price - wallet_deduct;
    }

   
    var gst_pct = GST_PERCT;

    const gst_amount = Math.round(total*(gst_pct/100));


    total += gst_amount

    const remain_after = total;

    payment_total = price + gst_amount;
    if(total <0){total=0}

    const obj= {
        message:'',
        horoscope_name:horoscope_name,
        wallet_balance,
        subtotal:subtotal,
        gst_perct:GST_PERCT,
        wallet_deduct:wallet_deduct,
        gst_amount:gst_amount,
        remain_after,
        total:total,
        payment_total,
        member:member,
        user,
        astrologer,
    }
    return obj;
}

const fetch_payable_amount_horoscope_new =async (req,res) =>{
    const {user_id,astrologer_id,skill_id}=req.body;
    const obj = await bill_payable_amount_horoscope(user_id,astrologer_id,skill_id);
    res.json({
        status:true,
        data:obj
    })
}


const horoscope_book_new = async (req,res) => {
    const {user_id,astrologer_id,skill_id} = req.body;
    var txn_id = 'h'+moment().utc()+user_id;
    const dateTime =await  currentTimeStamp();

    const billdata = await bill_payable_amount_horoscope(user_id,astrologer_id,skill_id);

    var total = 0;
    const user = billdata.user;
    const astrologer = billdata.astrologer;

    var member = billdata.member
    if(!member){
        member={
            type:'host',
            name:user.name,
            dob:user.dob,
            tob:user.birth_time,
            pob:user.place_of_birth,
            mothername:user.mother_name,
            fathername:user.father_name,
            gotro:user.gotro,
            spouse:user.spouse_name,
            language:language,
            message:'',
            id:0,
        };
    }

    var price = roundno(billdata.subtotal);
    var subtotal = parseFloat(price);

    var remain_after = billdata.remain_after;
    var wallet_balance = billdata.wallet_balance;
    var wallet_deduct = billdata.wallet_deduct;
    const payableAmt = parseFloat(billdata.total);
    var pmode="wallet_online";
    if(remain_after == 0){
        pmode="wallet"
    }else if(wallet_balance == 0){
        pmode="online";
    }

    const t = await sequelize.transaction();
    try {
        const storeData = {
            user_id,
            orderID:'SH'+moment().utc()+user_id,
            booking_type:2,
            assign_id:astrologer_id,
            type:4,
            subtotal,
            wallet_deduct:billdata.wallet_deduct,
            gst	:billdata.gst_amount,
            payable_amount:billdata.payment_total,
            payment_mode:pmode,
            status:0,
            txn_id:txn_id,
            is_paid:1,
            message:member.message,
            created_at:dateTime,
            user_name:member.name,
            user_gender:member.gender,
            user_dob:member.dob,
            user_tob:member.tob,
            user_pob:member.pob,
            user_language:member.language,
            horoscope_name:billdata.horoscope_name
        };
        const booking = await Booking.create(storeData
            , { transaction: t });

        const bookingInsertID = booking.id;
        // console.log('booking id',bookingInsertID);

        if(pmode=='online' || pmode=='wallet_online'){
            const transactiondata = {
                txn_name:'Horoscope Booking',
                booking_id:bookingInsertID,
                booking_txn_id:txn_id,
                txn_for:'booking',
                payment_mode:pmode,
                txn_amount:payableAmt,
                type:'debit',
                status:1,
                user_id:user_id,
                created_at:dateTime,
                updated_at:dateTime
            }
            await Transaction.create(transactiondata
                , { transaction: t });
        }
        if(wallet_deduct && parseFloat(wallet_deduct)){
            var old_wallet = parseFloat(user.wallet);
            var txn_amount =  parseFloat(wallet_deduct);
            var new_wallet = old_wallet-txn_amount;
            // if(new_wallet<0){new_wallet=0}
            var txn_type = 'debit';
            var transactiondata2 = {
                user_id:user_id,
                txn_name:'Horoscope Booking',
                booking_id:bookingInsertID,
                payment_mode:'wallet',
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

        horoscope_book_notification(user_id,astrologer_id,billdata.horoscope_name,bookingInsertID)
        set_astrologer_comission_to_order(bookingInsertID)
        call_reminder_ivr(astrologer_id)
        return res.json({
            status:true,
            message:'added!',
            data:booking,
        })

   
    } catch (error) {
        // If the execution reaches this line, an error was thrown.
        // We rollback the transaction.
        await t.rollback();
        return res.json(failedRes('failed!!'))
    }

}


const horoscope_book = async (req,res) => {
    const {user_id,astrologer_id,txn_id} = req.body;

    const dateTime =await  currentTimeStamp();
    var total = 0;
    const user = await User.findOne({
        where:{
            id:user_id
        }
    })
    const astrologer =await Astrologer.findOne({
        where:{
            id:astrologer_id
        }
    });

    var member =await Member.scope(['active']).findOne({
        order:[['id','desc']],
        where:{
            user_id:user_id
        }
    })
    if(!member){
        member={
            type:'host',
            name:user.name,
            dob:user.dob,
            tob:user.birth_time,
            pob:user.place_of_birth,
            mothername:user.mother_name,
            fathername:user.father_name,
            gotro:user.gotro,
            spouse:user.spouse_name,
            language:language,
            message:'',
            id:0,
        };
    }

    var price = roundno(astrologer.horoscope_price);
    var subtotal = parseFloat(price);

    const wallet_balance = parseFloat(user.wallet);

    var wallet_deduct = 0;

    if(wallet_balance >= price){
        wallet_deduct = price
        total += price - wallet_deduct
    }else{
        wallet_deduct = wallet_balance;

        total += price - wallet_deduct;
    }

    var gst_pct = GST_PERCT;

    const gst_amount = Math.round(total*(gst_pct/100));

    const remain_after = total;

    total += gst_amount
    if(total <0){total=0}

    var finalobj={
        member:member,
        subtotal:subtotal,
        wallet_balance,
        wallet_deduct:wallet_deduct,
        remain_after,
        gst_perct:gst_pct,
        gst_amount,
        total:total
    }

    const payableAmt = parseFloat(total);
    var pmode="wallet_online";
    if(remain_after == 0){
        pmode="wallet"
    }else if(wallet_balance == 0){
        pmode="online";
    }

    const t = await sequelize.transaction();
    try {
        const storeData = {
            user_id,
            orderID:'SH'+moment().utc()+user_id,
            booking_type:2,
            assign_id:astrologer_id,
            type:4,
            subtotal,
            wallet_deduct,
            gst	:gst_amount,
            payable_amount:payableAmt,
            payment_mode:pmode,
            status:0,
            txn_id:txn_id,
            is_paid:1,
            message:member.message,
            created_at:dateTime,
            user_name:member.name,
            user_gender:member.gender,
            user_dob:member.dob,
            user_tob:member.tob,
            user_pob:member.address,
            user_language:member.language
        };
        const booking = await Booking.create(storeData
            , { transaction: t });

        const bookingInsertID = booking.id;
        // console.log('booking id',bookingInsertID);

        if(pmode=='online' || pmode=='wallet_online'){
            const transactiondata = {
                txn_name:'Horoscope Booking',
                booking_id:bookingInsertID,
                booking_txn_id:txn_id,
                txn_for:'booking',
                payment_mode:pmode,
                txn_amount:payableAmt,
                type:'debit',
                status:1,
                user_id:user_id,
                created_at:dateTime,
                updated_at:dateTime
            }
            await Transaction.create(transactiondata
                , { transaction: t });
        }
        if(wallet_deduct && parseFloat(wallet_deduct)){
            var old_wallet = parseFloat(user.wallet);
            var txn_amount =  parseFloat(wallet_deduct);
            var new_wallet = old_wallet-txn_amount;
            if(new_wallet<0){new_wallet=0}
            var txn_type = 'debit';
            var transactiondata2 = {
                user_id:user_id,
                txn_name:'Horoscope Booking',
                booking_id:bookingInsertID,
                payment_mode:'wallet',
                booking_txn_id:GenerateUniqueID()+user_id,
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

        horoscope_book_notification(user_id,astrologer_id,'',bookingInsertID)
        return res.json({
            status:true,
            message:'added!',
            data:booking,
        })

        // return res.json({
        //     status:true,
        //     data:booking,
        // })
    } catch (error) {
        // If the execution reaches this line, an error was thrown.
        // We rollback the transaction.
        await t.rollback();
        return res.json(failedRes('failed!!'))
    }

}


const fetch_payable_amount_astrologer = async (req,res) => {
    var {user_id,astrologer_id,amount,mode} = req.body;
    var discount=0;
    var coupon={};
    var total = 0;

    var mode =mode? mode.toLowerCase():'';
    const astrologer =await Astrologer.findOne({
        where:{
            id:astrologer_id
        }
    });

    const member =await Kundalimatchuser.scope(['default']).findOne({
        order:[['id','desc']],
        where:{
            user_id:user_id
        }
    })

    var price = roundno(amount);
    var subtotal = parseFloat(price);
    total += subtotal;

    const couponapply =await Couponapply.findOne({
        order:[
            ['id','desc']
        ],
        where:{
            user_id:user_id
        }
    }).then(async (rs)=>{
        if(rs){
            const cop= await Coupon.scope(['astrologer']).findOne({where:{id:rs.coupon_id}}).then((cp)=>cp);
            var copdiscount=0;
            if(cop.discount_type =='flat'){
                 copdiscount = roundno(parseFloat(cop.amount));
            }else{
                copdiscount =roundno(subtotal*(parseFloat(cop.amount)/100))
            }
            // subtotal -= copdiscount;
            discount=copdiscount;
            // if(subtotal<0){subtotal=0;}
            return await cop;
        }
    });


    // var gst = roundno(price*(18/100));
    var gst = 0;

    // price += gst;

    total = subtotal - discount;
    if(total <0){total=0}

    return res.json({
        status:true,
        message:'',
        mode,
        astrologer,
        kundali_member:member,
        coupon:couponapply,
        subtotal:subtotal,
        discount:discount,
        gst:gst,
        total:total
    })

}

const astrologer_book = async (req,res) => {
    const {user_id} = req.body;
    var copdiscount=0;
    var {message,subtotal,discount,gst,donation,total,txn_id,astrologer_id,mode,schedule_date,schedule_time ,time_minutes,
    wallet_deduct,
    payment_mode
    } = req.body;
    // console.log(req.body);
    const dateTime =await  currentTimeStamp();
    var mode2 =mode? mode.toLowerCase():'';
    // console.log('mode - ',mode2);

   const astrologer = await Astrologer.findOne({
       where:{
           id:astrologer_id
       }
   })

   const couponapply =await Couponapply.findOne({
        order:[
            ['id','desc']
        ],
        where:{
            user_id:user_id
        }
    }).then(async (rs)=>{
        if(rs){
            const cop= await Coupon.scope(['astrologer']).findOne({where:{id:rs.coupon_id}}).then((cp)=>cp);
            if(cop.discount_type =='flat'){
                copdiscount = roundno(parseFloat(cop.amount));
            }else{
                copdiscount =roundno(subtotal*(parseFloat(cop.amount)/100))
            }
            // subtotal -= copdiscount;
            // discount=copdiscount;
            // if(subtotal<0){subtotal=0;}
            return await cop;
        }
    });

    const format1 = "YYYY-MM-DD HH:mm:ss"
    var sh_dt = moment(schedule_time, ["hh:mmA"]).format("HH:mm")
    var date1 = new Date(schedule_date+' '+sh_dt);
    const dateTime1 = moment(date1).format(format1);


    const member =await Kundalimatchuser.scope(['default']).findOne({
        order:[['id','desc']],
        where:{
            user_id:user_id
        }
    })

    const dob = moment(member.year+'-'+member.month+'-'+member.day).format('YYYY-MM-DD');
    const tob = ((member.hour ? member.hour : 00 )+':'+(member.min ? member.min : 00))

    const pmode = payment_mode ? payment_mode : 'online';
    var payableAmt = parseFloat(total)+parseFloat(donation ? donation : 0);
    
    const user = await User.findOne({
        where:{id:user_id}
    })
    // console.log('User ',user);

    var b_mode;
    switch (mode2) {
        case 'video':
            b_mode=1;
        case 'audio':
            b_mode=2;
            break;
        case 'chat':
            b_mode=3;
            break;
        default:
            break;
    }
    const t = await sequelize.transaction();
    try {

        const storeData = {
            user_id,
            orderID:'SH'+moment().utc()+user_id,
            booking_type:2,
            assign_id:astrologer_id,
            type:b_mode,
            subtotal,
            discount,
            gst	,
            coupon_id:couponapply?couponapply.id:0,
            coupon_code:couponapply?couponapply.code:'',
            coupon_discount:copdiscount,
            donation,
            total_minutes:time_minutes,
            time_minutes,
            payable_amount:payableAmt,
            payment_mode:pmode,
            status:0,
            txn_id:txn_id,
            message:message,
            created_at:dateTime,
            user_name:member.name,
            user_gender:member.gender,
            user_dob:dob,
            user_tob:tob,
            user_pob:member.address,
            is_paid:1,
            bridge_id:GenerateUniqueID()+moment().utc(),
            schedule_date,
            schedule_time:sh_dt,
            schedule_date_time:dateTime1,
            is_premium:astrologer.is_premium
        };
        const booking = await Booking.create(storeData
            , { transaction: t });
            const bookingInsertID = booking.id;
            // console.log('booking id',bookingInsertID);
        if(pmode=='online'){
            const transactiondata = {
                booking_id:bookingInsertID,
                booking_txn_id:txn_id,
                txn_for:'booking',
                payment_mode:pmode,
                txn_amount:payableAmt,
                type:'debit',
                status:1,
                user_id:user_id,
                created_at:dateTime,
                updated_at:dateTime
            }
            await Transaction.create(transactiondata
                , { transaction: t });
        }
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
        await Couponapply.destroy({
            where : {user_id:user_id}
        }
        , { transaction: t });

        await t.commit();


        return res.json({
            status:true,
            message:'added!',
            data:booking,
        })
    }catch (error) {
        // If the execution reaches this line, an error was thrown.
        // We rollback the transaction.
        await t.rollback();
        return res.json(failedRes('failed!!',error))
    }

}


const astrologer_book_new = async (req,res) => {
    const {user_id} = req.body;
    var {message,subtotal,discount,gst,donation,total,txn_id,astrologer_id,mode,schedule_date,schedule_time ,time_minutes,
    wallet_deduct,
    payment_mode
    } = req.body;
    // console.log(req.body);
    const dateTime = await currentTimeStamp();
    var copdiscount = 0;

   const astrologer = await Astrologer.findOne({
       where:{
           id:astrologer_id
       }
   })

    const format1 = "YYYY-MM-DD HH:mm:ss"
    var sh_dt = moment(schedule_time, ["hh:mmA"]).format("HH:mm")
    var date1 = new Date(schedule_date+' '+sh_dt);
    const dateTime1 = moment(date1).format(format1);

    
   const couponapply =await Couponapply.findOne({
        order:[
            ['id','desc']
        ],
        where:{
            user_id:user_id
        }
    }).then(async (rs)=>{
        if(rs){
            const cop= await Coupon.scope(['astrologer']).findOne({where:{id:rs.coupon_id}}).then((cp)=>cp);
            if(cop.discount_type =='flat'){
                copdiscount = roundno(parseFloat(cop.amount));
            }else{
                copdiscount =roundno(subtotal*(parseFloat(cop.amount)/100))
            }
            // subtotal -= copdiscount;
            // discount=copdiscount;
            // if(subtotal<0){subtotal=0;}
            return await cop;
        }
    });

    var member =await Kundalimatchuser.scope(['default']).findOne({
        order:[['id','desc']],
        where:{
            user_id:user_id
        }
    })
    
    const user = await User.findOne({
        where:{id:user_id}
    })
    var dob;
    var tob
    if(member){
         dob = moment((member.year ? member.year : '0000' )+'-'+(member.month ? member.month : '00' )+'-'+(member.day ? member.day : '00' )).format('YYYY-MM-DD');
         tob = ((member.hour ? member.hour : 00 )+':'+(member.min ? member.min : 00))
    
    }else{
         dob = user.dob
         tob = user.birth_time;
        member = {
            name:user.name,
            gender:user.gender,
            address:user.place_of_birth

        }
    }

   
    const pmode = payment_mode ? payment_mode : 'online';
    var payableAmt = parseFloat(total)+parseFloat(donation ? donation : 0);
    
    // console.log('User ',user);

    const t = await sequelize.transaction();
    try {

        const storeData = {
            user_id,
            orderID:'SH'+moment().utc()+user_id,
            booking_type:2,
            assign_id:astrologer_id,
            type:mode,
            subtotal,
            discount,
            gst	,
            donation,
            time_minutes,
            total_minutes:time_minutes,
            time_minutes,
            coupon_id:couponapply?couponapply.id:0,
            coupon_code:couponapply?couponapply.code:'',
            coupon_discount:copdiscount,
            payable_amount:payableAmt,
            payment_mode:pmode,
            status:0,
            txn_id:txn_id,
            message:message,
            created_at:dateTime,
            user_name:member.name,
            user_gender:member.gender,
            user_dob:dob,
            user_tob:tob,
            user_pob:member.address,
            is_paid:1,
            bridge_id:GenerateUniqueID()+moment().utc(),
            schedule_date,
            schedule_time:sh_dt,
            schedule_date_time:dateTime1,
            is_premium:astrologer.is_premium
        };
        const booking = await Booking.create(storeData
            , { transaction: t });
            const bookingInsertID = booking.id;
            // console.log('booking id',bookingInsertID);
        if(pmode=='online'){
            const transactiondata = {
                booking_id:bookingInsertID,
                txn_name:'Astrologer Book',
                booking_txn_id:txn_id,
                txn_for:'booking',
                payment_mode:pmode,
                txn_amount:payableAmt,
                type:'debit',
                status:1,
                user_id:user_id,
                created_at:dateTime,
                updated_at:dateTime
            }
            await Transaction.create(transactiondata
                , { transaction: t });
        }
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
                txn_name:'Astrologer Book',
                booking_txn_id:GenerateUniqueID()+user_id,
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
        await Couponapply.destroy({
            where : {user_id:user_id}
        }
        , { transaction: t });

        await t.commit();


        const inurl = imagePaths.poinvoiceUrl+bookingInsertID;
        // const title = "Booking Successful";
        // var tnme = ''
        // if(type == 1){
        //     tnme='Video'
        // }else if(type == 2){
        //     tnme = 'Audio'
        // }else if(type == 3){
        //     tname = "Chat";
        // }else if(type == 4){
        //     tname = "Horoscope"
        // }
        // const msg = "Hi "+user.name.toUpperCase()+",Your booking for astrologer "+astrologer.name.toUpperCase()+" "+tnme+" is successfull. Your Schedule Date & Time is "+schedule_date+" "+schedule_time;
        // send_fcm_push(user.device_token,title,msg,req.body);
        // send_schedule_notification(dateTime1,'Your puja is start', "Hi "+user.name.toUpperCase()+",Your booking for puja "+puja.name.toUpperCase()+" is started. Please Join, Thankyou!",req.body);

        return res.json({
            status:true,
            invoice:inurl,
            share_url:'http://139.59.25.187/astrologer-details/'+astrologer_id,
            message:'added!',
            data:booking,
        })
    }catch (error) {
        // If the execution reaches this line, an error was thrown.
        // We rollback the transaction.
        await t.rollback();
        return res.json(failedRes('failed!!',error))
    }

}

function convert_positive(a) { 
    // Check the number is negative 
    if (a < 0) { 
        // Multiply number with -1 
        // to make it positive 
        a = a * -1; 
    } 
    // Return the positive number 
    return a; 
} 

const booking_history = async (req,res) => {

    const {user_id}=req.body;
    var {limit,offset,type}=req.body;
    // console.log('booking history',req.body);
    const cdateTime = await currentTimeStamp();;
    var whereobj={};
    if(type == 'upcoming'){
        whereobj = {
            user_id:user_id,
            // status:{
            //     [Op.in]:[0,6]
            // }
        }
    }else{
        whereobj = {
            user_id:user_id,
            // status:{
            //     [Op.ne]:0
            // }
        }
    }

    // Booking.belongsTo(User, {foreignKey: 'user_id'})
    const count = await Booking.count({
        where:whereobj,
    });
    const booking = await Booking.scope(['orderDesc']).findAll({
        limit:parseInt(limit),
        offset:parseInt(offset),
        where:whereobj,
        // attributes:['id','orderID','mode','type','booking_type','assign_id','subtotal','discount','gst','donation','payable_amount','coupon_code','booking_for','user_name','user_phone','user_email',
        // 'user_gender','user_tob','user_dob','user_pob','user_fathername','user_mothername','user_gotro','user_spouse','schedule_date','schedule_time','payment_mode','txn_id','status','created_at','time_minutes']
    }).then(async (bookings)=>{
        for (let booking of bookings) {
            // const inurl = "http://139.59.25.187/shaktipeeth_new/Booking_management/invoice_genrate/"+booking.id;
            if(booking.booking_type==1){
                const bh =await Bookinghistory.findAll({
                    where:{
                        booking_id:booking.id
                    }
                })
                for (let pj of bh) {
                    const puja =await Puja.findOne({
                        where:{
                            id:pj.puja_id
                        }
                    })

                    const puja_reshdule_hour = parseInt(1);
                    const checkhourbeforstartpuja=convert_positive(parseInt(moment(pj.schedule_date_time).diff(cdateTime, 'hours')));
                    var reschedule_power = 0;
                    var cancel_power = 0;
    
                    if(checkhourbeforstartpuja > puja_reshdule_hour){
                        reschedule_power=1;
                    }
                    if(checkhourbeforstartpuja > puja_reshdule_hour){
                        cancel_power=1;
                    }

                    if(pj.status ==2 || pj.status ==3 || pj.status == 4 ||  pj.status == 5 ||  pj.status == 6 ||  pj.status == 1){
                        reschedule_power=0;
                        cancel_power=0
                    }

                    // reschedule_power=1;
                    // cancel_power=1;

                    pj.dataValues.imageUrl = puja.imageUrl
                    pj.dataValues.reschedule_power=reschedule_power;
                    pj.dataValues.cancel_power=cancel_power;
                    pj.dataValues.checkhourbeforstartpuja=checkhourbeforstartpuja;
                    pj.dataValues.puja_reshdule_hour=puja_reshdule_hour;
                    // pj.dataValues.puja = puja
                    pj.dataValues.invoiceURL = 'http://139.59.25.187/shaktipeeth_new/Booking_management/invoice_genrate/'+pj.booking_id;
                }
                booking.dataValues.pujas=bh;
            }else{
                const astro = await Astrologer.findOne({
                    where:{id:booking.assign_id}}
                    );
                booking.dataValues.astrologer=astro;

                var reschedule_power = 0;
                var cancel_power = 0;
                if(booking.type !=4){
                    const checkhourbeforstartpuja=convert_positive(parseInt(moment(booking.schedule_date_time).diff(cdateTime, 'hours')));
                    if(checkhourbeforstartpuja > 1){
                        reschedule_power=1;
                    }
                    if(checkhourbeforstartpuja > 1){
                        cancel_power=1;
                    }
                }else{
                    if(booking.status == 0){
                        reschedule_power=1;
                        cancel_power=1;
                    }
    
                }
                if(booking.status == 0){
                    reschedule_power=1;
                    cancel_power=1;
                }

                // reschedule_power=1;
                // cancel_power=1;

                var tnme = ''
                if(type == 1){
                    tnme='Video'
                }else if(type == 2){
                    tnme = 'Audio'
                }else if(type == 3){
                    tname = "Chat";
                }else if(type == 4){
                    tname = "Horoscope"
                }
                booking.dataValues.mode=tnme;
                booking.dataValues.reschedule_power=reschedule_power;
                booking.dataValues.cancel_power=cancel_power;
                booking.dataValues.astrologer=astro;
            }
        }
        return await bookings
    })

    return res.json({
        status:true,
        count,
        limit,
        offset,
        data:booking
    })
}

// const broadcast_booking_history = async (req,res) => {
//     const {user_id,booking_id}=req.body;

//     const booking = await Booking.findAll({
//         where:{
//             user_id:user_id
//         }
//     })
// }

const booking_details = async (req,res) => {
    const {user_id,booking_id}=req.body;
    var type;
    const cdateTime = await currentTimeStamp();;
    const bk = await Booking.scope(['orderDesc']).findOne({
        where:{
            id:booking_id,
            user_id:user_id
        },
        // attributes:['id','orderID','mode','type','booking_type','assign_id','subtotal','discount','gst','donation','payable_amount','coupon_code','booking_for','user_name','user_phone','user_email',
        // 'user_gender','user_tob','user_dob','user_pob','user_fathername','user_mothername','user_gotro','user_spouse','schedule_date','schedule_time','payment_mode','txn_id','status','created_at']
    }).then(async (booking)=>{
        if(booking.booking_type==1){
            const bh =await Bookinghistory.findAll({
                where:{
                    booking_id:booking.id
                }
            })
            for (let pj of bh) {
                const puja =await Puja.findOne({
                    where:{
                        id:pj.puja_id
                    }
                })

                const puja_reshdule_hour = parseInt(1);
                const checkhourbeforstartpuja=convert_positive(parseInt(moment(pj.schedule_date_time).diff(cdateTime, 'hours')));
                var reschedule_power = 0;
                var cancel_power = 0;

                if(checkhourbeforstartpuja > puja_reshdule_hour){
                    reschedule_power=1;
                }
                if(checkhourbeforstartpuja > puja_reshdule_hour){
                    cancel_power=1;
                }

                if(pj.status ==2 || pj.status ==3 || pj.status == 4 ||  pj.status == 5 ||  pj.status == 6 ||  pj.status == 1){
                    reschedule_power=0;
                    cancel_power=0
                }

                // reschedule_power=1;
                // cancel_power=1;

                pj.dataValues.imageUrl = puja.imageUrl
                pj.dataValues.reschedule_power=reschedule_power;
                pj.dataValues.cancel_power=cancel_power;
                pj.dataValues.checkhourbeforstartpuja=checkhourbeforstartpuja;
                pj.dataValues.puja_reshdule_hour=puja_reshdule_hour;
                // pj.dataValues.puja = puja
                pj.dataValues.invoiceURL = 'http://139.59.25.187/shaktipeeth_new/Booking_management/invoice_genrate/'+pj.booking_id;
            }
            booking.dataValues.pujas=bh;
        }else{
            const astro = await Astrologer.findOne({
                where:{id:booking.assign_id}}
                );
            booking.dataValues.astrologer=astro;

            var reschedule_power = 0;
            var cancel_power = 0;
            if(booking.type !=4){
                const checkhourbeforstartpuja=convert_positive(parseInt(moment(booking.schedule_date_time).diff(cdateTime, 'hours')));
                if(checkhourbeforstartpuja > 1){
                    reschedule_power=1;
                }
                if(checkhourbeforstartpuja > 1){
                    cancel_power=1;
                }
            }else{
                if(booking.status == 0){
                    reschedule_power=1;
                    cancel_power=1;
                }

            }
            if(booking.status == 0){
                reschedule_power=1;
                cancel_power=1;
            }

            // reschedule_power=1;
            // cancel_power=1;

            var tnme = ''
            if(type == 1){
                tnme='Video'
            }else if(type == 2){
                tnme = 'Audio'
            }else if(type == 3){
                tname = "Chat";
            }else if(type == 4){
                tname = "Horoscope"
            }
            booking.dataValues.mode=tnme;
            booking.dataValues.reschedule_power=reschedule_power;
            booking.dataValues.cancel_power=cancel_power;
            booking.dataValues.astrologer=astro;
        }
        return await booking
    })

    return res.json(successRes('fetched',bk))
}

const reschedule_puja_booking = async (req,res) => {
    const {user_id,id,schedule_date,schedule_time} = req.body;
    const bookingHist =await Bookinghistory.findOne({
        where:{
            user_id:user_id,
            id:id
        }
    });

    // console.log('reschedule',req.body);
    const format1 = "YYYY-MM-DD HH:mm:ss"
    var sh_dt = moment(schedule_time, ["hh:mmA"]).format("HH:mm")
    var date1 = new Date(schedule_date+' '+sh_dt);
    const dateTime1 = moment(date1).format(format1);

    var updateData = {
        schedule_date,
        schedule_time:sh_dt,
        schedule_date_time:dateTime1
    }
    // console.log(updateData);
    await Bookinghistory.update(updateData, {
        where: { id: id },
      })
        .then((usr) => res.json(successRes("Updated", usr)))
        .catch((err) => res.json(failedRes("Something went wrong", err)));
}




const cancel_puja_booking = async (req,res) => {
    const {user_id,id } = req.body;
    // console.log('cancel',req.body);
    const bookingHist =await Bookinghistory.findOne({
        where:{
            user_id:user_id,
            id:id
        }
    });

    var updateData = {
        status:2
    }
    await Bookinghistory.update(updateData, {
        where: { id:id },
      })
        .then((usr) => res.json(successRes("Cancelled", usr)))
        .catch((err) => res.json(failedRes("Something went wrong", err)));
}
// const reschedule


const reschedule_astrologer_booking = async (req,res) => {
    const {user_id,id,schedule_date,schedule_time} = req.body;
    const booking = Booking.findOne({
        where:{
            user_id:user_id,
            id:id
        }
    });

    const format1 = "YYYY-MM-DD HH:mm:ss"
    var sh_dt = moment(schedule_time, ["hh:mmA"]).format("HH:mm")
    var date1 = new Date(schedule_date+' '+sh_dt);
    const dateTime1 = moment(date1).format(format1);

    var updateData = {
        schedule_date,
        schedule_time,
        schedule_date_time:dateTime1
    }
    await Booking.update(updateData, {
        where: { id: id },
      })
        .then((usr) => res.json(successRes("Updated", usr)))
        .catch((err) => res.json(failedRes("Something went wrong", err)));
}



const cancel_astrologer_booking = async (req,res) => {
    const {user_id,id } = req.body;
    const booking =await Booking.findOne({
        where:{
            user_id:user_id,
            id:id
        }
    });

    var updateData = {
        status:3
    }
    await Booking.update(updateData, {
        where: { id: id },
      })
        .then((usr) => res.json(successRes("Cancelled", usr)))
        .catch((err) => res.json(failedRes("Something went wrong", err)));
}


const realtime_bookinghistory = async (req,res) =>{
    const {user_id,type} = req.body;
    var {limit,offset}=req.body;
    if (!offset) {
        offset = 0;
    }
    if (!limit) {
        limit = 10;
    }

    try {
        const bkg = await Booking.findAll({
            where:{
                user_id:user_id,
                type:type,
                status:{
                    [Op.in]:[0,1,2,3,4,5,6]
                }
            },
            order:[['id','desc']],
            limit:parseInt(limit),
            offset:parseInt(offset)
        }).then(async (bookings) => {
            if(bookings){
                for (let booking of bookings) {
                    const user =await User.findOne({
                        where:{
                            id:booking.user_id
                        },
                        attributes:['id','name','phone','email','image','imageUrl']
                    })
                    booking.dataValues.user=user;
        
                    const astrologer =await Astrologer.findOne({
                        where:{
                            id:booking.assign_id,
                            status:{
                                [Op.in]:[0,1]
                            },
                            approved:{
                                [Op.in]:[0,1]
                            }
                        },
                        attributes:['id','name','phone','email','image','imageUrl']
                    })
                    booking.dataValues.astrologer=astrologer;
                    
                    if(booking.total_minutes <= 4 && booking.refund_request_raised == 0){
                        //able_to_refund- 0->no , 1->can , 2->refund completed , 3->ProcessingInstruction, 4->cancelled
                        booking.dataValues.able_to_refund = 1
                    }else if(booking.refund_request_raised == 1){
                        booking.dataValues.able_to_refund = 3
                    }else if(booking.refund_request_raised == 2){
                        booking.dataValues.able_to_refund = 2
                    }else if(booking.refund_request_raised == 3){
                        booking.dataValues.able_to_refund = 4
                    }
                    else{
                        booking.dataValues.able_to_refund = 0
                    }
                }
                return await bookings;
            }
        });
        return res.json({
            status:true,
            limit,
            offset,
            data:bkg
        })
    } catch (error) {
        return res.json({
            status:false,
            data:[]
        })
    }
   

   
}

const get_cancellation_reasons = async (req,res) => {
    const data = await CancellationReason.scope(['orderAsc']).findAll();
    res.json(data?successRes('',data):failedRes(''))
}

const get_broadcast_joined_users = async (req,res) => {
    const users =await Broadcastjoin.findAll();

    res.json(successRes('fetched!',users))
}

const refund_request_raise = async (req,res) => {
    const {user_id,booking_id,reason} = req.body;
    const bookingd = await Booking.findOne({
        where:{
            id:booking_id,
            user_id,
            refund_request_raised:0
        }
    })
    const dateTime = currentTimeStamp();
    if(bookingd){

        const updd = await Booking.update({
            refund_request_raised:1,
            refund_request_on:dateTime,
            refund_request_reason:reason
        },{
            where:{
                id:bookingd.id
            }
        })

        if(updd){
            res.json(successRes('successfully raised'))
        }else{

            res.json(failedRes('failed'))
        }

    }else{
        res.json(failedRes('something went wrong'))
    }
}


const get_astrologer_prices = async (req,res) => {
    const {astrologer_id} = req.body
    const ast = await Astrologer.findOne({
        where:{
            id:astrologer_id
        },
        attributes:['id','price_per_mint_chat','price_per_mint_video','price_per_mint_audio']
    });
    res.json(ast ? successRes('',ast):failedRes(''));

}

const set_astrologer_discount = async (req,res) => {

    const {type,discount,start_date,end_date,astrologer_id} = req.body;

    var st = moment(start_date).format('YYYY-MM-DD')
    var et = moment(end_date).format('YYYY-MM-DD')
    const dateTime = currentTimeStamp();

    const storedata = {
        discount_on:type.toLowerCase(),
        discount:discount,
        discount_start:st,
        discount_end:et,
    }
    console.log(storedata);
    const udt = await Astrologer.update(storedata,{
        where:{
            id:astrologer_id
        }
    })
    res.json(successRes('updated',udt))

    // if(check_add){
    //     const udt = await AstrologerDiscount.update(storedata,{
    //         where:{
    //             id:check_add.id
    //         }
    //     })
    //     res.json(successRes('updated',udt))
    // }else{
    //     const str = await AstrologerDiscount.create(storedata)
    //     res.json(successRes('added',str))
    // }
}

module.exports = {
    fetch_payable_amount_puja,
    booking_puja,
    fetch_puja_coupons,
    apply_coupon,
    remove_coupon,
    puja_booking_history,
    fetch_payable_amount_horoscope,
    fetch_horoscope_coupons,
    horoscope_book,
    fetch_payable_amount_astrologer,
    fetch_astrologer_coupons,
    astrologer_book,
    booking_history,
    booking_details,
    reschedule_puja_booking,
    cancel_puja_booking,
    reschedule_astrologer_booking,
    cancel_astrologer_booking,
    astrologer_book_new,
    realtime_bookinghistory,

    get_broadcast_joined_users,
    fetch_payable_amount_horoscope_new,
    horoscope_book_new,
    get_cancellation_reasons,
    refund_request_raise,
    get_astrologer_prices,
    set_astrologer_discount
};
