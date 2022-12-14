const { customer_user } = require('../config/app.config');
const db=require('../models/index');
const {User,sequelize,Review}=db;
const moment = require("moment");
const { Speciality, Skill, Transaction, Astrologer,Booking, Favourite, Follower } = require('../models/index');
const { Op } = require('sequelize')

const getUserIpAddress = (req) => req.header('x-forwarded-for') || req.connection.remoteAddress;


const isPhoneExists =(phone)=>User.count({ where: { phone: phone} });

const isEmailExists =(email)=>User.count({ where: { email: email,email_verified:1 } });

const fetchUserByPhone =(phone)=>User.findOne({ where: { phone: phone} });

const fetchUserByID =(id)=>User.findOne({ where: { id: id} });

// subtract('5.30','hours')
const currentTimeStamp = (format='YYYY-MM-DD HH:mm:ss') =>{ 
    
    return moment().format(format)
    
};

const addDays = (date, day = 1, format='YYYY-MM-DD HH:mm:ss') =>{ 
    return moment(date, format).add(day, "days").format(format)
    
};


const isFollowAstro =async (user_id,astrologer_id)=>{ 
    try {
        return await Follower.findOne({ where: { user_id: user_id,astrologer_id:astrologer_id } });
        
    } catch (error) {
        return false;
    }
}



const averageRatingAstrologer =async (id) =>
{
    try {
        const rt = await Review.scope(['astrologer']).findOne({
            where:{type_id:id},
            attributes: [[sequelize.fn('avg', sequelize.col('rate')), 'average'],[sequelize.fn('count', sequelize.col('id')), 'total_reviews']],
        });
        return rt;
    } catch (error) {
        return false;
    }
}



const astrologer_total_reviews_by_rate = (id,rate) => Review.scope(['astrologer']).count({
    where:{type_id:id,
    rate:rate
    },
});




const averageRatingPuja = (id) => Review.scope(['puja']).findOne({
    where:{type_id:id},
    attributes: [[sequelize.fn('avg', sequelize.col('rate')), 'average'],[sequelize.fn('count', sequelize.col('id')), 'total_reviews']],
});



const astrologer_max_min = () => Astrologer.findOne({
    attributes: [[sequelize.fn('min', sequelize.col('price_per_mint_video')), 'min_price'],[sequelize.fn('max', sequelize.col('price_per_mint_video')), 'max_price']],
});

const astroTotalClientsServed = (astro_id) => Booking.count({where:{
    assign_id:astro_id,
    status:2
}})

const checkIfAstrologerFav = (astrologer_id,user_id) => Favourite.findOne({
    astrologer_id:astrologer_id,
    user_id:user_id
})
const checkIfFav =(astrologer_id=0,user_id=0)=>Favourite.count({ where: { astrologer_id: astrologer_id,user_id:user_id } });


// const countbusyTime =

const astrologerSpecialities =async (astr_id) => {
    try {
        const query = `SELECT ms.name,ms.type FROM master_specialization as ms INNER JOIN skills as sk ON sk.speciality_id = ms.id WHERE sk.user_id = ${astr_id}`;
        const data = await sequelize.query(query,{
            model: Speciality,
            mapToModel: true
        })
        

        // await Speciality.belongsTo(Skill, { targetKey: "speciality_id", foreignKey: "id" });
        // const data = await Speciality.findAll({
        // attributes:['name','type'],
        // include: {
        //     model: Skill,
        //     // as: 'skills',
        //     where: {
        //     user_id: astr_id
        //     }
        // }
        // });
        return data;
    } catch (error) {
        return false;
    }
    
}

const get_puja_name_by_lang =async (condtion='en',data) => {
    if (condtion == 'en') {
        return data.name;
    }else if(condtion == 'hi'){
        return data.name_in_hindi
    }else if(condtion == 'gu'){
        return data.name_in_gujrati;
    }else{
        return data.name;
    }
}


const get_puja_description_by_lang =async (condtion='en',data) => {
    if (condtion == 'en') {
        return data.description;
    }else if(condtion == 'hi'){
        return data.desc_in_hindi
    }else if(condtion == 'gu'){
        return data.desc_in_gujrati;
    }else{
        return data.description;
    }
}

const addTransaction =async (data) => {

    const {name,booking_id,user_id,booking_txn_id,payment_mode,type,old_wallet,txn_amount,update_wallet,status} = data;
    const dateTime = moment().format();
    return await Transaction.create({
        name:name,
        booking_id:booking_id,
        user_id:user_id,
        booking_txn_id:booking_txn_id,
        payment_mode:payment_mode,
        type:type,
        old_wallet:parseFloat(old_wallet?old_wallet:0),
        txn_amount:parseFloat(txn_amount?txn_amount:0),
        update_wallet:parseFloat(update_wallet?update_wallet:0),
        status:status,
        created_at:dateTime,
        updated_at:dateTime
    })
}

const checkIfAstrologerBusy = async (astrologer_id) => {
    const dateTime = currentTimeStamp();
    const todaydate = currentTimeStamp('YYYY-MM-DD')
    const chck = await Booking.scope(['astrologer']).findOne({
        where:{
            assign_id:astrologer_id,
            status:{
              [Op.in]:[0,1,6]
            },
            type:{
              [Op.in]:[1,2,3]
            },
            schedule_date_time:{
                [Op.gt]: todaydate+' 00:00:00',
                [Op.lt]: todaydate+' 24:00:00'
              }
        },
        order:[
            ['schedule_date_time','asc']
        ]
    }).then(async (rs)=>{
        if (rs) {
            var a =await moment(rs.schedule_date_time,'YYYY-MM-DD HH:ssa');
            var b =await moment(dateTime,'YYYY-MM-DD HH:ssa')
            var diff = a.diff(b, 'minutes');

            if(moment(dateTime,'YYYY-MM-DD HH:mma').isBetween(moment(rs.schedule_date_time,'YYYY-MM-DD HH:mma'),moment(rs.schedule_date_time,'YYYY-MM-DD HH:mma').add(rs.total_minutes))){
                var obj = {
                    busy:true,
                    timemin:diff
                }
                return obj
            }else{
                var obj = {
                    busy:false,
                    timemin:0
                }
            }
        }else{
            var obj = {
                busy:false,
                timemin:0
            }
            return obj
        }
    })
    return chck;
}


const count_diff_minutes = (time1,time2) => {
    var a = moment(time1);

    var b = moment(time2)
    var diffinseconds = Math.abs(a.diff(b, 'seconds'));
    var diff=1;
    // var diffseconds = Math.abs(a.diff(b, 'minutes'));
    

    var diffinminutes = Math.round(diffinseconds/60);
    if(diffinminutes > 0){
        diff=diffinminutes;
    }

    return diff;
}


const checkIfAstrologerBusyTime = async (astrologer_id) => {
    try {
        const todaydate = currentTimeStamp('YYYY-MM-DD')
        const chck = await Booking.scope(['astrologer']).findOne({
            where:{
                assign_id:astrologer_id,
                status:{
                [Op.in]:[0,1,6]
                },
                type:{
                [Op.in]:[1,2,3]
                },
                schedule_date_time:{
                    [Op.gt]: todaydate+' 00:00:00',
                    [Op.lt]: todaydate+' 24:00:00'
                },
                // is_premium:0
            },
            order:[
                ['schedule_date_time','asc']
            ]
        })
        return chck;
    } catch (error) {
        return false;
    }
    
}
// const averageRatingPuja = (id) => Review.scope(['puja']).findOne({
//     where:{type_id:id},
//     attributes: [[sequelize.fn('avg', sequelize.col('rate')), 'average'],[sequelize.fn('count', sequelize.col('id')), 'total_reviews']],
// });

module.exports={
    isPhoneExists,
    isEmailExists,
    fetchUserByPhone,
    fetchUserByID,
    currentTimeStamp,
    addDays,
    averageRatingAstrologer,
    averageRatingPuja,
    astrologerSpecialities,
    addTransaction,
    astrologer_max_min,
    get_puja_name_by_lang,
    get_puja_description_by_lang,
    checkIfAstrologerBusy,
    checkIfAstrologerFav,
    checkIfFav,
    checkIfAstrologerBusyTime,
    astrologer_total_reviews_by_rate,
    astroTotalClientsServed,
    count_diff_minutes,
    getUserIpAddress,
    isFollowAstro
}