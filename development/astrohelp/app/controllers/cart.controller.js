const { successRes, failedRes } = require("../helpers/response.helper");
const db = require("../models/index");
const { Cart, Puja} = db;
const Op=db.sequelize.Op;
const moment = require("moment");
const { Member, Pujalocation, Venue, City, Bookinghistory, Ledgercode, sequelize, Booking, User } = require("../models/index");
const { currentTimeStamp } = require("../helpers/user.helper");

const check_if_already_added_puja =async (id,user_id) => {
    return await Cart.findOne({
        where:{
            user_id:user_id,
            puja_id:id,
            added_by:'self'
        }
    })
}

const GenerateUniqueID = function () {
    // Math.random should be unique because of its seeding algorithm.
    // Convert it to base 36 (numbers + letters), and grab the first 9 characters
    // after the decimal.
    return  Math.random().toString(36).substr(2, 9);
};

const add_to_cart = async (req,res) => {
    const {id,user_id}=req.body;

    const checkIfalreadyAdd =await check_if_already_added_puja(id,user_id).then((rs)=>rs);
    if(checkIfalreadyAdd){
        return res.json(successRes('added',checkIfalreadyAdd))
    }
    const dateTime = moment().format();
    const storeData = {
        type_id:id,
        type:1,
        user_id:user_id,
        created_at:dateTime,
        qty:1
    }
    await Cart.create(storeData).then((rs)=>res.json(successRes('added!!',rs)))
    .catch((err)=>res.json(failedRes('something went wrong',err)))
}



const add_puja_to_cart = async (req,res) => {
    var {puja_id,user_id,venue_id,location_id,schedule_date,schedule_time,city,location,venue,puja_location_id}=req.body;
    const dateTime = moment().format();

    const user = await User.findOne({
        where:{
            id:user_id
        }
    })
    const format1 = "YYYY-MM-DD HH:mm:ss"
    var sh_dt = moment(schedule_time, ["hh:mmA"]).format("HH:mm")
    var date1 = new Date(schedule_date+' '+sh_dt);
    const dateTime1 = moment(date1).format(format1);

    const puja = await Puja.findOne({
        where:{
            id:puja_id
        }
    });
    var member =await Member.findOne({
        order:[
            ['id','desc']
        ],
        where:{
            user_id:user_id
        }
    }).then((rs)=>rs);
    
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

    if(venue_id){

        await Pujalocation.findOne({
            where : {
                puja_id:puja_id,
                location_id:location_id
            }
        }).then((rs)=>{
            puja_location_id=rs.id
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
                location=rs.name;
                city=rs.name;
            }
        })
    }

    // var poojatype='online';
    // if(puja.pooja_type==1){
    //     poojatype='online'
    // }else if(puja.pooja_type == 2){
    //     poojatype='ground';
    // }

    const checkIfalreadyAdd =await check_if_already_added_puja(puja_id,user_id).then((rs)=>rs);
    if(checkIfalreadyAdd){
        const updateData = {
            type_id:puja.pooja_type,
            type:1,
            user_id:user_id,
            puja_id:puja_id,
            city:city,
            venue:venue,
            schedule_date,
            schedule_time,
            schedule_date_time:dateTime1,
            created_at:dateTime,
            puja_location_id,
            location_id,
            amount:puja.price,
            discount_price:puja.discount_price,
            added_by:'self',
            host_type:member.type,
            host_name:member.name,
            host_dob:member.dob,
            host_tob:member.tob,
            host_pob:member.pob,
            host_mothername:member.mothername,
            host_fathername:member.fathername,
            host_gotro:member.gotro,
            host_spouse:member.spouse,
            host_id:member.id,
            qty:1
        }
        const updt= await Cart.update(updateData, {
            where: { id: checkIfalreadyAdd.id },
          }).then((rs)=>rs);
        return res.json(successRes('added',checkIfalreadyAdd))
    }else{
        const storeData = {
            type_id:puja.pooja_type,
            type:1,
            user_id:user_id,
            puja_id:puja_id,
            city:city,
            venue:venue,
            schedule_date,
            schedule_time,
            schedule_date_time:dateTime1,
            created_at:dateTime,
            puja_location_id,
            location_id,
            amount:puja.price,
            discount_price:puja.discount_price,
            added_by:'self',
            host_type:member.type,
            host_name:member.name,
            host_dob:member.dob,
            host_tob:member.tob,
            host_pob:member.pob,
            host_mothername:member.mothername,
            host_fathername:member.fathername,
            host_gotro:member.gotro,
            host_spouse:member.spouse,
            host_id:member.id,
            qty:1
        }
        await Cart.create(storeData).then((rs)=>res.json(successRes('added!!',rs)))
        .catch((err)=>res.json(failedRes('something went wrong',err)))
    }
}


const delete_puja_cart = async (req,res) => {
    const {cart_id,user_id}=req.body;
    Cart.destroy({
        where:{
            id:cart_id,
            user_id:user_id
        }
    }).then((rs)=>res.status(200).json(successRes('deleted',rs)))
    .catch((err)=>res.json(failedRes('failed',err)))
}
const roundno = (no) => Math.round(no);


const get_puja_cart = async (req,res) => {
    const {user_id} = req.body;
    // var {donation}=req.body;
    var total_amount = 0;
    const cts = await Cart.findAll({
        where:{
            user_id:user_id,
            added_by:'self'
        }
    }).then(async(carts)=>{
        for (let cart of carts) {
            const puja = await Puja.findOne({
               where:{ id:cart.puja_id}
            }).then((rs)=>rs);
            var price = roundno(puja.price);
            var discount_type = puja.discount_type;
            var pujadiscount =0;
            total_amount += price;
            cart.dataValues.puja=puja;
            cart.dataValues.puja_price=price;
            cart.dataValues.puja_discount_type=discount_type;
            cart.dataValues.puja_discount=pujadiscount;
        }
        return await carts
    })
    if(!cts){
        return res.status(200).json(failedRes('failed',cts))
    }else{
        return res.status(200).json({
            status:true,
            total_amount,
            data:cts
        })
    }
}

const bookpuja_of_cart = async (req,res) => {
    const {user_id} = req.body;
    var total_amount = 0;
    var bookinghist = [];
    var {donation,discount,gst}=req.body;
    const dateTime = currentTimeStamp();

    await Cart.findAll({
        where:{
            user_id:user_id,
            added_by:'self'
        }
    }).then(async (carts)=>{
        for (let cart of carts) {
            const puja = await Puja.findOne({
               where:{ id:cart.puja_id }
            }).then((rs)=>rs);
            var price = roundno(puja.price);

            total_amount += price;
            const ledger =await Ledgercode.findOne({
                where:{
                    id:puja.ledger_code_id
                }
            })
            var tax_name = ledger ? ledger.ledger_name : '';
            var tax_percentage = puja.tax_percentage;
            var tax_price = puja.tax_price;
            var discount_price = puja.discount_price;
            // cart.dataValues.puja=puja;
            // cart.dataValues.puja_price=price;
            // cart.dataValues.puja_discount_type=discount_type;
            // cart.dataValues.puja_discount=pujadiscount;


            const storeBookingHistory = {
                user_id,
                // booking_id:bookingInsertID,
                suborderID:'SHP'+moment().utc()+user_id,
                bridge_id:GenerateUniqueID()+moment().utc(),
                puja_id:cart.puja_id,
                name:puja.name,
                amount:price,
                tax_breakup:puja.price_breakup,
                host_type:cart.host_type,
                host_name:cart.host_name,
                host_dob:cart.host_dob,
                host_tob:cart.host_tob,
                host_pob:cart.host_pob,
                host_mothername:cart.host_mothername,
                host_fathername:cart.host_fathername,
                host_gotro:cart.host_gotro,
                host_spouse:cart.host_spouse,
                member_id:cart.host_id,
                guests:cart.guests,
                schedule_date:cart.schedule_date,
                schedule_time:cart.schedule_time,
                schedule_date_time:cart.schedule_date_time,
                created_at:dateTime,
                booking_location:cart.location,
                venue:cart.venue,
                main_location_id:cart.puja_location_id,
                location_id:cart.location_id,
                tax_percentage,
                tax_amount:tax_price,
                tax_name,
                discount_price
            }
            bookinghist.push(storeBookingHistory);

        }
    })

    // const  a =  await Bookinghistory.bulkCreate(bookinghist)
    // res.json(bookinghist);

    const t = await sequelize.transaction();
    try {
        const storeData = {
            user_id,
            orderID:'SH'+moment().utc()+user_id,
            booking_type:1,
            subtotal:total_amount,
            discount,
            gst	,
            donation,
            payable_amount:total_amount,
            payment_mode:'online',
            txn_id:GenerateUniqueID()+user_id,
            status:0,
            created_at:dateTime
        };
        const booking = await Booking.create(storeData
            , { transaction: t });
        const bookingInsertID = booking.id;


        for (let bh of bookinghist) {
            bh.booking_id=bookingInsertID;
        }

        await Bookinghistory.bulkCreate(bookinghist
        , { transaction: t });

        await Cart.destroy({
            where:{
                user_id:user_id
            }
        }, { transaction: t })
        await t.commit();
        return res.json(successRes('done!!',booking))
    } catch (error) {

        // If the execution reaches this line, an error was thrown.
        // We rollback the transaction.
        await t.rollback();

        return res.json(failedRes('failed!!',error))

    }
}
module.exports = {
    add_to_cart,
    add_puja_to_cart,
    delete_puja_cart,
    get_puja_cart,
    bookpuja_of_cart
};
