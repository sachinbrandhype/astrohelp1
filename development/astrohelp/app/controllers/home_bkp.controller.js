const { successRes, failedRes } = require("../helpers/response.helper");
const { getTimeStops } = require("../helpers/timeslot.helper");
const { averageRatingAstrologer, fetchUserByID, currentTimeStamp, averageRatingPuja,astrologerSpecialities,astrologer_max_min, checkIfAstrologerBusy, checkIfAstrologerFav, checkIfFav, checkIfAstrologerBusyTime, astrologer_total_reviews_by_rate, astroTotalClientsServed,
count_diff_minutes,
isFollowAstro
} = require("../helpers/user.helper");
const db = require("../models/index");
const { User, Banner, Setting, Puja, Yoga, Post, City, Guest, Venue, Horoscope,Astrologer,Review,Pujalocation, Pujatimeslot,Enquiry} = db;
const { Op } = require('sequelize')
const moment = require("moment");
const { sequelize, Speciality,Transaction, Skill, Notification, God, Temple, Booking, Bookinghistory, Priest, Supervisor, DateWise, Bookingrequest, FAQ, Support, Language, Broadcast, Follower, Member } = require("../models/index");
const { send_booking_complete_notification, send_alert_for_event, send_fcm_push_astrologer } = require("../helpers/notification.helper");
// const { create_broadcast_event } = require("../socket/socket");


const fetch_explore_banner_puja = async (req, res) => {
  const banners= await Banner.scope(['active','main','orderAsc'])
    .findAll()
    .then((data) => data);
  const settings = await Setting.findOne().then((st)=>st)

  const pujas = await Puja.scope(['active','orderAsc']).findAll({
    limit:10
  }).then((pj)=>pj);

  return res.send({
    status: true,
    settings,
    banners,
    pujas
  });
};


const fetch_explore = async (req, res) => {
  const banners= await Banner.scope(['active','main','orderAsc'])
    .findAll()
    .then((data) => data);
  const settings = await Setting.findOne({
    attributes:['explorehome_topbg_url','astrologyhome_topbg_url','ropeway_bg_url','explorehome_topbg','ropeway_bg','ropeway_txt','astrologyhome_topbg','id']
  }).then((st)=>st)

  const pujas = await Puja.scope(['active','orderAsc']).findAll({
    limit:10
  }).then((pj)=>pj);
  // const yogas = await Yoga.scope(['active','orderAsc']).findAll({limit:10}).then((yg)=>yg);
  const yogas = [];


  const posts = await Post.scope(['active','video','orderDesc']).findAll({limit:10}).then(ps=>ps);

  const astro =  await Astrologer.scope(['active','online']).findAll({ order: [["name", "asc"]],limit:10}).then(async (astrologers)=>{
    for (let astrologer of astrologers) {
      const rating = await averageRatingAstrologer(astrologer.id).then((rate)=>rate)
      Speciality.belongsTo(Skill, { targetKey: "speciality_id", foreignKey: "id" });
      const experties =await astrologerSpecialities(astrologer.id)
      astrologer.dataValues.expertiesData=experties
      astrologer.dataValues.rating=rating
    }
    return await astrologers;
  })

  return res.send({
    status: true,
    settings,
    banners,
    pujas,
    yogas,
    astrologers:astro,
    posts
  });
};

const fetch_tv_posts = async (req,res) => {
  const {user_id} = req.body;
  var {limit,offset}=req.body;
  if (!offset) {
      offset = 0;
  }
  if (!limit) {
      limit = 10;
  }
  const posts = await Post.scope(['active','video','orderDesc']).findAll({
    limit:parseInt(limit),
    offset:parseInt(offset)
  }).then(ps=>ps);
  if(!posts){
    return res.json(failedRes('no data found',posts))
  }else{
    return res.json(successRes('fetched!!',posts))
  }

}


const fetch_explore_for_web = async (req, res) => {
  const banners= await Banner.scope(['active','main','orderAsc'])
    .findAll()
    .then((data) => data);
  const pujas = await Puja.scope(['active','orderAsc']).findAll({
    limit:10
  }).then((pj)=>pj);
  const yogas = await Yoga.scope(['active','orderAsc']).findAll({limit:10}).then((yg)=>yg);

  const posts = await Post.scope(['active','video','orderDesc']).findAll({limit:10}).then(ps=>ps);
  return res.send({
    status: true,
    banners,
    pujas,
    yogas,
    posts
  });
};


const fetch_explore_yoga_posts =async (req,res) => {

  const yogas = await Yoga.scope(['active','orderAsc']).findAll({limit:10}).then((yg)=>yg);

  const posts = await Post.scope(['active','video','orderDesc']).findAll({limit:10}).then(ps=>ps);

  return res.send({
    status: true,
    yogas,
    posts
  });
}

const fetch_wallet_and_notification_count = async (req,res) => {
  const {user_id}=req.body;
  const user = await User.findOne({
    where:{
      id:user_id
    }
  })
  const notification_count =await Notification.scope(['active','user','unread']).count({
    where:{
      user_id:user_id
    }
  });

  // console.log('user',user);
  // console.log('notification_count',notification_count);


  return res.json({
    status:true,
    wallet:user?user.wallet:0,
    user:user,
    notification_count:notification_count
  })
}

const fetch_notifications = async (req,res) => {
  var {limit,offset,user_id}=req.body;
  if(!limit){
    limit=10;
  }
  if(!offset){
    offset=0;
  }

  const notifications =await Notification.scope(['active','user']).findAll({
    where:{

      user_id:user_id
    },
    order:[['id','desc']],
    limit:parseInt(limit),
    offset:parseInt(offset)
  })

  Notification.scope(['active','user','unread']).update({
    read:1
  },{
    where:{
      user_id:user_id
    }
  })

  return res.json(successRes('fetched!!',notifications))

}

const fetch_pujas = async (req,res) => {
  var {limit,offset}=req.body;
  if(!limit){
    limit=10;
  }
  if(!offset){
    offset=0;
  }
  const count =await Puja.scope(['active','orderAsc']).count();
  const pujas = await Puja.scope(['active','orderAsc']).findAll({
    limit:parseInt(limit),
    offset:parseFloat(offset)}).then(async pujas=>{
    for (let puja of pujas) {
      await Pujalocation.findAll({
        where:{
          puja_id:puja.id
        }
      }).then(async (pujalocation)=>{
        if(pujalocation){
          var city_name='';
          for (let pl of pujalocation) {
            const city =await City.findOne({
              where:{id:pl.location_id}
            })
            city_name += city.name+','
          }
          puja.dataValues.city_name=city_name.replace(/,\s*$/, "");
        }else{
          puja.dataValues.city_name=''
        }
      })
    }
    return await pujas
  });
  return res.json({
    status:true,
    count,
    limit,
    offset,
    data:pujas
  });
}



const fetch_puja_review_locations_details = async (req,res) => {
  const {user_id,puja_id} = req.body;

  var totalreview = await averageRatingPuja(puja_id).then((rs)=>rs);
  var rev = await Review.scope(['puja']).findAll({where:{type_id:puja_id},limit:10}).then(async (reviews)=>{
    for (let review of reviews) {
      const user = await User.findOne({where:{id:review.user_id},
        // attributes: ['name','imageUrl'],
      }).then(rs=>rs);
      review.dataValues.user=user;
    }
    return await reviews
  })

  var pujalocation = await Pujalocation.findAll({
    where:{
      puja_id:puja_id
    }
  }).then(async (lcs)=>{
    for (let lc of lcs) {
      const city = await City.findOne({where:{id:lc.location_id}}).then(ct=>ct.name ? ct.name : '');
      lc.dataValues.name=city
    }
    return await lcs
  })
  var pujadetails =await Puja.findOne({where:{id:puja_id}}).then(pj=>pj);

  return res.json({
    status:true,
    totalreview,
    reviews:rev,
    pujalocation,
    pujadetails
  })

}


const fetch_puja_venues =async (req,res) => {
  const {user_id,puja_id,location_id}=req.body;

  await Pujalocation.findOne({
    where:{
      location_id:location_id,
      puja_id:puja_id
    }
  }).then(async (lc)=>{
    if(lc){
      var venue_ids =await lc.venue_id.split("|");
      await Venue.scope(['active','orderAsc']).findAll({
        where:{
          id:venue_ids
        }
      }).then((rs)=>res.json(successRes('',rs)))
    }
    return res.json(failedRes('failed',lc));

  }).catch(err=>res.json(failedRes('no location found',err)))
}

const fetch_cities = async (req,res) => {

  const cities =await City.scope(['active']).findAll().then(dt=>dt).catch(err=>res.json(failedRes('something went wrong',err)));
  return res.json(successRes('fetched',cities))
}

const fetch_venues = async (req,res) => {
  const {city_id}=req.body;
  const venues = await Venue.scope(['active']).findAll({where:{city_id:city_id}}).then(rs=>rs);
  return res.json(successRes('fetched',venues))
}

const fetch_puja_details =async (req,res) => {
  const {id,user_id}=req.body;
  await Puja.findOne({
    where : {id:id}
  })
  .then(async (rs)=>{
    // const ids_arr = await rs.venue_ids.split("|");
    // console.log(ids_arr);
    // await Venue.scope(['active']).findAll({
    //   where: {id: {[Op.in]: ids_arr}}
    // }).then((venue)=>rs.dataValues.venues=venue)
    return res.json(successRes('find',rs))
  })
  .catch(err=>res.json(failedRes('not found',err)))
}

const time_slots =async (req,res) => {

  const slots = getTimeStops();
  res.json(successRes('fetch',slots))
}

const add_guests = async (req,res) => {
  const {user_id,names,total} = req.body;
  const dateTime =await currentTimeStamp();
  const storeData={
    user_id,
    names,
    total:total,
    created_at:dateTime
  }
  // console.log(storeData);
  await Guest.create(storeData).then(rs=>res.status(200).json(successRes('add!!',rs)))
  .catch(err=>res.status(500).json('failed',err))
}


const fetch_astrologer_home =async (req,res) => {
  const {user_id}=req.body;
  const settings = await Setting.findOne().then((st)=>st)
  const user = await User.findOne({where:{id:user_id},
    attributes: ['name'],
  }).then((rs)=>rs);
  const horoscopes = await Horoscope.scope(['active']).findAll({limit:1}).then((rs)=>rs);
  const banners= await Banner.scope(['active','mid','orderAsc'])
  .findAll()
  .then((data) => data);

  const astro =  await Astrologer.scope(['active']).findAll({ order: [["name", "asc"]],limit:10}).then(async (astrologers)=>{
    for (let astrologer of astrologers) {
      const rating = await averageRatingAstrologer(astrologer.id).then((rate)=>rate)

      Speciality.belongsTo(Skill, { targetKey: "speciality_id", foreignKey: "id" });
      const experties =await astrologerSpecialities(astrologer.id)

      astrologer.dataValues.expertiesData=experties
      astrologer.dataValues.rating=rating
    }
    return await astrologers;
  })

  res.status(200).json({
    status:true,
    message:'',
    settings,
    user,
    horoscopes,
    banners,
    astrologers:astro
  })
}




const fetch_astrohelp24_home =async (req,res) => {
 
 
  const banners= await Banner.scope(['active','main','orderAsc'])
  .findAll()

  var query = "SELECT astro.*,brd.bridge_id FROM astrologers as astro INNER JOIN broadcasts as brd ON brd.astrologer_id=astro.id WHERE brd.status IN(0,1) ORDER BY brd.id ASC";
  const astro = await sequelize.query(query, {
    model: Astrologer,
    mapToModel: true // pass true here if you have any mapped fields
  }).then(async (astrologers)=>{
    for (let astrologer of astrologers) {

      const rating = await averageRatingAstrologer(astrologer.id)
      const experties =await astrologerSpecialities(astrologer.id)
      const isfv = 0;
      const busy = await  checkIfAstrologerBusyTime(astrologer.id)
      if(busy){
        astrologer.dataValues.online_status=2
        astrologer.dataValues.wait_time=2
      }
      astrologer.dataValues.expertiesData=experties
      astrologer.dataValues.rating=rating
      astrologer.dataValues.is_favourite=isfv?1:0
    }
    return await astrologers;
  })


  res.status(200).json({
    status:true,
    message:'',
    banners,
    live_astrologers:astro
  })
}



const fetch_astrologers =async (req,res) => {

  const {user_id}=req.body;
  var {mode} = req.body;
  var {limit,offset,can_take_horoscope,online_status} = req.body;
  if (!offset) {
    offset = 0;
  }
  if (!limit) {
    limit = 1000;
  }

  var busy_astrologers_arr = [];
  var online_astrologers_arr = [];
  var offline_astrologers_arr = [];
  var total_astrologers = [];

  const dateTime = moment(currentTimeStamp());

  // console.log(req.body);

  mode = mode.toLowerCase();

  var whereObj = {
  }


  if (mode=='chat') {
    whereObj = {
      online_consult:{
        [Op.in]:[1,4,5,6],
      }
    }
  }else if(mode=='audio'){
    whereObj = {
      online_consult:{
        [Op.in]:[3,4,6,7],
      }
    }
  }else if(mode == 'video'){
    whereObj = {
      online_consult:{
        [Op.in]:[2,4,5,7],
      }
    }
  }else if(mode == 'report'){
    whereObj={
      can_take_horoscope:1
    }
  }

  try {
    
    // const count =await Astrologer.scope(['active']).count({
    //   where:whereObj
    // });
    const momenttime = moment('YYYY-MM-DD')

    const astro =  await Astrologer.scope(['active']).findAll({ 
      order: [["name", "asc"]],
      where:whereObj,
      limit:parseInt(limit),offset:parseInt(offset)
    }).then(async (astrologers)=>{
        if(astrologers){
          for (let astrologer of astrologers) {

            const rating = await averageRatingAstrologer(astrologer.id)
            // const experties =await astrologerSpecialities(astrologer.id)
            const isfv =0
            const busy = await  checkIfAstrologerBusyTime(astrologer.id)
           

            var experties_string = astrologer.expertise;
            // if(experties && experties.length){
            //   experties_string = experties[0].name
            // }
            const is_follow =await isFollowAstro(user_id?user_id:0,astrologer.id)
            astrologer.dataValues.is_follow=is_follow?1:0
            astrologer.dataValues.experties_string=experties_string
            astrologer.dataValues.expertiesData=[]
            astrologer.dataValues.rating=rating
            astrologer.dataValues.is_favourite=isfv

            if(astrologer.discount_on && astrologer.discount != 0){
              const discount_on_arr = astrologer.discount_on.split('|')
              if(discount_on_arr.indexOf(mode?mode:'') >= 0 && astrologer.discount_start && astrologer.discount_end){
                if(!momenttime.isBetween(moment(astrologer.discount_start), moment(astrologer.discount_end))){
                  astrologer.dataValues.discount = 0
                }
              }
            }else{
              astrologer.dataValues.discount = 0;
            }

            if(busy){
              astrologer.dataValues.online_status=2
              var wait_time=parseFloat(busy.total_minutes)-count_diff_minutes(dateTime,busy.schedule_date_time);
              if(wait_time<0){
                wait_time =0;
              }
              astrologer.dataValues.wait_time=wait_time;
              astrologer.dataValues.queues =await fetch_queue_users_function(astrologer.id);

              const check_queue = await check_if_user_queued(user_id?user_id:0,astrologer.id);
              astrologer.dataValues.is_queued = check_queue?1:0

              busy_astrologers_arr.push(astrologer);
            }else{
              if(astrologer.online_status == 1){
                online_astrologers_arr.push(astrologer);
              }else{
                offline_astrologers_arr.push(astrologer)
              }
            }
        }
      }
      return await astrologers;
    })

    total_astrologers = [...busy_astrologers_arr,...online_astrologers_arr,...offline_astrologers_arr]
    return res.json({
      status:true,
      limit,
      offset,
      // count,
      data:total_astrologers
    })
  } catch (error) {
    return res.json(failedRes('something went wrong',error))
  }

  

}


const search_astrologers = async (req,res) => {

  var {search,user_id,mode} = req.body;
  if(!user_id){
    user_id=0;
  }

  var whereObj = {
    name: {
      [Op.like]: '%'+search+'%'
    }
  }
  if (mode=='chat') {
    whereObj = {
      name: {
        [Op.like]: '%'+search+'%'
      },
      online_consult:{
        [Op.in]:[1,4,5,6],
      }
    }
  }else if(mode=='audio'){
    whereObj = {
      name: {
        [Op.like]: '%'+search+'%'
      },
      online_consult:{
        [Op.in]:[3,4,6,7],
      }
    }
  }else if(mode == 'video'){
    whereObj = {
      name: {
        [Op.like]: '%'+search+'%'
      },
      online_consult:{
        [Op.in]:[2,4,5,7],
      }
    }
  }else if(mode == 'report'){
    whereObj={
      name: {
        [Op.like]: '%'+search+'%'
      },
      can_take_horoscope:1
    }
  }

  try {
    const astro =  await Astrologer.scope(['active']).findAll({ order: [["name", "asc"]],

    where: whereObj

    }).then(async (astrologers)=>{
      if(astrologers){
        const dateTime = moment(currentTimeStamp());
        for (let astrologer of astrologers) {

          const rating = await averageRatingAstrologer(astrologer.id)
          // const experties =await astrologerSpecialities(astrologer.id)
          const isfv =0
          const busy = await  checkIfAstrologerBusyTime(astrologer.id)
          if(busy){
            astrologer.dataValues.online_status=2
            var wait_time=parseFloat(busy.total_minutes)-count_diff_minutes(dateTime,busy.schedule_date_time);
            if(wait_time<0){
              wait_time =0;
            }
            astrologer.dataValues.wait_time=wait_time;
  
            // astrologer.dataValues.queues =await fetch_queue_users_function(astrologer.id);
            astrologer.dataValues.queues =[];
  
            const check_queue = await check_if_user_queued(user_id?user_id:0,astrologer.id);
            astrologer.dataValues.is_queued = check_queue?1:0
  
          }
 
          const is_follow =await isFollowAstro(user_id?user_id:0,astrologer.id)
          astrologer.dataValues.is_follow=is_follow?1:0
          astrologer.dataValues.experties_string=astrologer.expertise
          astrologer.dataValues.expertiesData=[]
          astrologer.dataValues.rating=rating
          astrologer.dataValues.is_favourite=isfv?1:0
  
          // const rating = await averageRatingAstrologer(astrologer.id)
          // const experties =await astrologerSpecialities(astrologer.id)
          // const isfv = 0
  
          // astrologer.dataValues.expertiesData=experties
          // astrologer.dataValues.rating=rating
          // astrologer.dataValues.is_favourite=isfv?1:0
  
          // const busy = await  checkIfAstrologerBusyTime(astrologer.id)
          // if(busy){
          //   astrologer.dataValues.online_status=2
          // }
        }
      }
   
      return await astrologers;
    })
    return res.json(successRes('',astro))
  } catch (error) {
    return res.json(failedRes('something went wrong!',error))
  }
  
}



const search_pujas = async (req,res) => {
  var {search} = req.body;
    const pujas = await Puja.scope(['active','orderAsc']).findAll({
      where: {
        name: {
          [Op.like]: '%'+search+'%'
        }
      }
    });
    return res.json(successRes('',pujas))
}




const fetch_astrologer_details =async (req,res) => {
  const {id,user_id}=req.body;
  const astro =  await Astrologer.scope(['active']).findOne({
    where:{
      id:id
    }
    }).then(async (astrologer)=>{
      

      const rating = await averageRatingAstrologer(astrologer.id)
      const experties =await astrologerSpecialities(astrologer.id)
      // const isfv = await  checkIfFav(astrologer.id,user_id)
      const isfv = 0
      astrologer.dataValues.expertiesData=experties
      astrologer.dataValues.rating=rating
      // astrologer.dataValues.total_reviews_by_rate={
      //   one:await astrologer_total_reviews_by_rate(astrologer.id,1),
      //   two:await astrologer_total_reviews_by_rate(astrologer.id,2),
      //   three:await astrologer_total_reviews_by_rate(astrologer.id,3),
      //   four:await astrologer_total_reviews_by_rate(astrologer.id,4),
      //   five:await astrologer_total_reviews_by_rate(astrologer.id,5),
      // }

      astrologer.dataValues.is_favourite=isfv?1:0

      const busy = await  checkIfAstrologerBusyTime(astrologer.id)
      if(busy){
        astrologer.dataValues.online_status=2
        astrologer.dataValues.wait_time=2
      }

      var rev = await Review.scope(['astrologer']).findAll({where:{type_id:id},limit:10,order:[['id','desc']]}).then(async (reviews)=>{
        for (let review of reviews) {
          const user = await User.findOne({where:{id:review.user_id},
          });
          review.dataValues.user=user;
        }
        return await reviews
      })
      astrologer.dataValues.reviews=rev
      astrologer.dataValues.served= await astroTotalClientsServed(astrologer.id);

      // return res.json(successRes('fetched',astrologer))
      return astrologer
  })


  return res.json(successRes('fetched',astro))
}


// const averageRatingAstrologer = (id) => Review.findOne({
//   where:{astrologer_id:id},
//   attributes: [[sequelize.fn('avg', sequelize.col('rate')), 'average'],[sequelize.fn('count', sequelize.col('id')), 'total_reviews']],
// });

const fetch_astrologers_on_home = async (req,res) => {
  var {limit,offset} = req.body;
  if (!offset) {
    offset = 0;
  }
  if (!limit) {
    limit = 10;
  }
 
  const astro =  await Astrologer.scope(['active']).findAll({ order: [["name", "asc"]],limit: parseInt(limit),offset: parseInt(offset)}).then(async (astrologers)=>{
    for (let astrologer of astrologers) {
      const rating = await averageRatingAstrologer(astrologer.id).then((rate)=>rate)
      astrologer.dataValues.rating=rating
    }
    return await astrologers;
  })

  return res.status(200).json(successRes("fetch",astro))

}

const add_enquiry = async (req,res) => {
  const {user_id,name,email,phone,message,puja_id}=req.body;
  await Enquiry.create({
    user_id,
    name,
    email,
    phone,
    message,
    type_id:puja_id,
    type:1
  }).then((rs)=>res.json(successRes('added!',rs)))
  .catch((err)=>res.json(failedRes('failed',err)))
}


const fetch_puja_time_slots = async (req,res) => {
  const {puja_id,user_id,location_id,date}=req.body;

  // const puja = Puja.findByPk(puja_id).then((pj)=>{
  //     res.json(pj)
  // }).then((err)=>res.json(failedRes('failed',err)))
  const dt = await moment(date, "YYYY-MM-DD HH:mm:ss");
  const currentDate =await currentTimeStamp();
  const dayname=dt.format('dddd').substring(0,3).toLowerCase();;
  var morning=[];
  var evening=[];
  var stock ;
  var is_available_anytime = 0;
  // console.log(dayname);
  // await Pujatimeslot.findOne({
  //   where:{
  //     puja_id:puja_id,
  //     date	:date
  //   }
  // }).then(async (tm)=>{
  //   if(tm){
  //     var day_wise_time =await JSON.parse(tm.day_wise_time);
  //     for (const [key, value] of Object.entries(day_wise_time)) {
  //       if(key === dayname){
  //         for (let time_obj of value) {
  //             const tm = await moment(time_obj.start, "HH:mm:ss");
  //             var currentHour = tm.format("HH");
  //             if (currentHour >= 3 && currentHour < 12){
  //               morning.push(time_obj.start)
  //             }else{
  //               evening.push(time_obj.start)
  //             }
  //         }
  //       }
  //     }
  //   }
  // })
  //console.log('time',req.body);
  await Pujalocation.findOne({
    where:{
      location_id:location_id,
      puja_id:puja_id
    }
  }).then(async (pl)=>{
      if(!pl){return res.json(failedRes('failed',pl))}
      var day_wise_time =await JSON.parse(pl.day_wise_time);
      var day_wise_stock =await JSON.parse(pl.day_wise_stock);
      var any_time =await JSON.parse(pl.any_time);

      // const dtwise =await DateWise.findOne({
      //   where:{
      //     puja_id:puja_id,
      //     date:date
      //   }
      // })
      // if(dtwise){
      //   const tms = JSON.parse(dtwise.json)
      //   for (let time_obj of tms) {
      //       const tm = await moment(date+' '+time_obj.start, "YYYY-MM-DD HH:mma");

      //       var currentHour = currentTimeStamp();
      //       console.log('CURRENT - '+currentHour+' Puja - '+tm);

      //       var currentHourampm = tm.format("a");

      //       // console.log(currentHour);
      //       // console.log('currentHouram',currentHouram);

      //       var obj = {isSelected:'',tm:time_obj.start};

      //       // var ampm = tm.format("HH");

      //       // if (currentHour >= 3 && currentHour < 12){
      //       if(moment(currentHour,'YYYY-MM-DD HH:mma').isSameOrBefore(tm)){
      //         if (currentHourampm=='am'){

      //           morning.push(obj)
      //         }else{
      //           evening.push(obj)
      //         }
      //       }
      //   }
      //   if(await day_wise_stock){
      //     stock = day_wise_stock[key]
      //   }

      //   if(await any_time){
      //     is_available_anytime = any_time[key]
      //   }

      // }else{
        
      // }

     
      for (const [key, value] of Object.entries(day_wise_time)) {
        // console.log(key, value);
        if(key === dayname){
          for (let time_obj of value) {


              const tm = await moment(date+' '+time_obj.start, "YYYY-MM-DD HH:mma");

              var currentHour =await currentTimeStamp();
              console.log('CURRENT - '+currentHour+' Puja - '+tm);

              var currentHourampm = tm.format("a");

              // console.log(currentHour);
              // console.log('currentHouram',currentHouram);

              var obj = {isSelected:'',tm:time_obj.start};

              // var ampm = tm.format("HH");

              // if (currentHour >= 3 && currentHour < 12){
              if(moment(currentHour,'YYYY-MM-DD HH:mma').isSameOrBefore(tm)){
                if (currentHourampm=='am'){

                  morning.push(obj)
                }else{
                  evening.push(obj)
                }
              }
              
          }
          if(await day_wise_stock){
            stock = day_wise_stock[key]
          }

          if(await any_time){
            is_available_anytime = any_time[key]
          }
        }
      }

      var time_slots = {
        dayname,
        stock,
        is_available_anytime,
        morning,
        evening
      }
      return res.json(successRes('fetch',time_slots))

  })
}




const fetch_astrologer_time_slots = async (req,res) => {
  const {id,user_id,date}=req.body;
  const dt = await moment(date, "YYYY-MM-DD HH:mm:ss");
  const dayname=dt.format('dddd').substring(0,3).toLowerCase();;
  var morning=[];
  var evening=[];
  await Astrologer.findOne({
    where:{
      id:id,
    }
  }).then(async (pl)=>{
      if(!pl){return res.json(failedRes('failed',pl))}
      var day_wise_time =await JSON.parse(pl.online_counsult_time);
      for (const [key, value] of Object.entries(day_wise_time)) {
        if(key === dayname){
          for (let time_obj of value) {
              const tm = await moment(time_obj.start, "HH:mma");
              const tm2 = await moment(date+' '+time_obj.start, "YYYY-MM-DD HH:mma");
    
              var currentHourampm = tm.format("a");

              var obj = {isSelected:'',tm:time_obj.start};
              const currentHour =await currentTimeStamp();

              // if (currentHour >= 3 && currentHour < 12){
              if(moment(currentHour,'YYYY-MM-DD HH:mma').isSameOrBefore(tm2)){
                if (currentHourampm=='am'){

                  morning.push(obj)
                }else{
                  evening.push(obj)
                }
              }
          }
        }
      }

      var time_slots = {
        status:true,
        minutePrices : JSON.parse(pl.time_on_amount),
        data : {dayname,
        morning,
        evening}
      }
      return res.json(time_slots)
  })
  .catch(err=>res.json(failedRes('failed',err)))
}



const fetch_puja_filters = async (req,res) => {
  const {user_id}=req.body;

  const god =await God.scope(['active']).findAll();
  const temple = await Temple.scope(['active']).findAll();
  const city = await City.scope(['active']).findAll();
  // const city = [];


  const category = [
    {
      id:2,
      name:'Ground',
      is_selected:''
    },
    {
      id:1,
      name:'Online',
      is_selected:''
    },
  ];
  return res.json({
    status:true,
    message:'',
    category,
    god,
    temple,
    location:city
  })
}

const search_puja_by_filters = async (req,res) => {
  const {user_id}=req.body;
  var {god,temple,location,category} = req.body;

    var god_arr_logic = '';
    if(god){
      var god_arr =god.split("|");
      if(god_arr.length){
        const godlnt = god_arr.length;
        for (let g = 0; g < godlnt; g++) {
  
          if(g>0){
            god_arr_logic += ' OR ';
          }
          god_arr_logic += 'FIND_IN_SET('+god_arr[g]+',gods)'
        }
  
      }
    }
    

    var temple_arr_logic = '';
    if(temple){
      var temple_arr =temple.split("|");
      if(temple_arr.length){
        const templelnt = temple_arr.length;
        for (let g = 0; g < templelnt; g++) {
  
          if(g>0 || god_arr_logic != ''){
            temple_arr_logic += ' OR ';
          }
          temple_arr_logic += 'FIND_IN_SET('+temple_arr[g]+',temples)'
        }
      }
    }
   

    var category_arr_logic = '';
    if(category){
      var category_arr =category.split("|");
      if(category_arr.length){
        const online_groud = category_arr.join()+',3';
        if(temple_arr_logic !== '' || god_arr_logic !== ''){
          category_arr_logic += ' AND ';
        }else{
          category_arr_logic += ' AND ';
        }
        category_arr_logic += ' pooja_type IN ('+online_groud+') '
      }
    }

    var location_arr_logic = '';
    var location_condition = '';
    if(location){
      var location_arr =location.split("|");
      if(location_arr.length){
        const location_join = location_arr.join();
        location_arr_logic = " INNER JOIN puja_location_table as plt ON plt.puja_id = puja.id "
        location_condition = " AND plt.location_id IN ("+location_join+") ";

      }
    }

    var query;

    if(god_arr_logic !== '' || temple_arr_logic !== ''){
      query = 'SELECT puja.* FROM puja '+location_arr_logic+' WHERE ('+god_arr_logic+' '+temple_arr_logic+') AND puja.status = 1'+location_condition+category_arr_logic;
    }else{
      query = 'SELECT puja.* FROM puja '+location_arr_logic+' WHERE puja.status = 1'+location_condition+category_arr_logic;
    }
  
    const pujas = await sequelize.query(query, {
      model: Puja,
      mapToModel: true // pass true here if you have any mapped fields
    })
    .then(async pujas=>{
      for (let puja of pujas) {
        await Pujalocation.findAll({
          where:{
            puja_id:puja.id
          }
        }).then(async (pujalocation)=>{
          if(pujalocation){
            var city_name='';
            for (let pl of pujalocation) {
              const city =await City.findOne({
                where:{id:pl.location_id}
              })
              city_name += city.name+','
            }
            puja.dataValues.city_name=city_name.replace(/,\s*$/, "");
          }else{
            puja.dataValues.city_name=''
          }
        })
      }
      return await pujas
    });


    return res.json(successRes('fetched',pujas))

}



const fetch_astrologer_filters = async (req,res) => {
  const {user_id} = req.body;
  const speciality = await Speciality.scope(['speciality','active']).findAll();
  const service = await Speciality.scope(['service','active']).findAll();
  const astrologer_max_mi = await astrologer_max_min();
  const language =await Language.findAll();

  const rating = [
    {
      id:1,
      name:'All Ratings',
      is_selected:''
    },
    {
      id:2,
      name:'3 Star and above',
      is_selected:''
    },
    {
      id:3,
      name:'Only 5 Start',
      is_selected:''
    },
  ];

  
  const online_ofline = [
    {
      id:1,
      name:'online',
      is_selected:''
    },
    {
      id:0,
      name:'offline',
      is_selected:''
    },
    {
      id:2,
      name:'Busy',
      is_selected:''
    },

  ];
  const gender = [
    {
      id:1,
      name:'male',
      is_selected:''
    },
    {
      id:2,
      name:'female',
      is_selected:''
    },
  ];
  const country = [
    {
      id:1,
      name:'India',
      is_selected:''
    },
    {
      id:2,
      name:'Outside India',
      is_selected:''
    },
  ];

  return res.json({
    status:true,
    message:'',
    online_ofline,
    speciality,
    service,
    rating,
    gender:gender,
    country:country,
    astrologer_max_min:astrologer_max_mi,
    language
  })
}


const search_astro_filter = async (req,res) =>{
  var {speciality,service,online_ofline,price_min,price_max,sort_by,language} = req.body;
  const {user_id} = req.body;
  // console.log(req.body);
  var speciality_arr=[];
  var service_arr=[];
  var language_arr=[];
  var online_ofline_arr = [];
  if(service.length>0){
    service_arr = service.split("|");
  }
  if(speciality.length>0){
    speciality_arr = speciality.split("|");
  }

  var whereinstring = speciality_arr.concat(service_arr);
  var uniqueChars = [...new Set(whereinstring)];
  
  var query;
  if(uniqueChars !== '' && uniqueChars && uniqueChars.length>0){
    var wherespser = uniqueChars.join('|')
    query = "SELECT astro.* FROM astrologers as astro INNER JOIN skills as skills ON skills.user_id = astro.id LEFT JOIN reviews as rv ON rv.type_id = astro.id WHERE astro.status = 1 AND skills.speciality_id IN ("+wherespser+") "
   
  }else{
    query = "SELECT astro.* FROM astrologers as astro LEFT JOIN reviews as rv ON rv.type_id = astro.id WHERE astro.status = 1 "+language_arr_logic
  }
// console.log(query);

res.json({success:'success'})
}


const search_astrologer_by_filters = async (req,res) => {
  var {speciality,service,online_ofline,price_min,price_max,sort_by,language} = req.body;
  const {user_id} = req.body;

  // console.log('request');

  // console.log(req.body);
  // 'SELECT * FROM astrologers '
  var speciality_arr=[];
  var service_arr=[];
  var language_arr=[];

  var online_ofline_arr = [];

  // // if(speciality.length >0){
  // //   speciality_arr = speciality.split("|");
  // // }

  // if(service.length>0){
  //   service_arr = service.split("|");
  // }

  // if(online_ofline.length>0){
  //   online_ofline_arr = online_ofline.split("|");
  // }


  // var language_arr_logic = '';
  // if(language.length>0){
  //   var language_arr =language.split("|");
  //   if(language_arr.length){
  //     const languagelnt = language_arr.length;
  //     for (let g = 0; g < languagelnt; g++) {

  //       // if(g>0 || god_arr_logic != ''){
  //       //   temple_arr_logic += ' OR ';
  //       // }
  //       if(g==0){
  //         language_arr_logic += '('
  //       }
       
  //       language_arr_logic += ' FIND_IN_SET('+language_arr[g]+',astro.languages) '

  //       if(g>0 && g != (languagelnt-1)){
  //           language_arr_logic += ' OR ';
  //       }

  //       if(g==(languagelnt-1)){
  //         language_arr_logic += ')'
  //       }
  //     }
  //   }
  // }

  // var whereinstring = speciality_arr.concat(service_arr);
  // const whereinstring_a = whereinstring.join()

  // console.log('wherestring', whereinstring);
  var query;
  // if(whereinstring_a !== ''){
  //   query = "SELECT astro.* FROM astrologers as astro INNER JOIN skills as skills ON skills.user_id = astro.id WHERE astro.status = 1 AND skills.speciality_id IN ("+whereinstring+") "+language_arr_logic
   
  // }else{
  //   query = "SELECT astro.* FROM astrologers as astro WHERE astro.status = 1 "+language_arr_logic
  // }
  query = "SELECT astro.* FROM astrologers as astro INNER JOIN skills as skills ON skills.user_id = astro.id WHERE astro.status = 1 AND skills.speciality_id="+service+" "



  // if(online_ofline.length){
  //   const online_ofline_str = online_ofline_arr.join();
  //   query += " AND astro.online_status IN("+online_ofline_str+")";
  // }
  // if(price_min && price_max){
  //   query += " AND astro.price_per_mint_video BETWEEN "+price_min+" AND "+price_max;
  // }

  if(sort_by){
    const orderby = " ORDER BY ";

    if(sort_by == 'ratinglowtohigh'){
        query = "SELECT astro.* FROM astrologers as astro INNER JOIN reviews as rv ON rv.type_id = astro.id INNER JOIN skills as skills ON skills.user_id = astro.id WHERE astro.status = 1 AND rv.type = 2  AND skills.speciality_id = "+service+" ";

        // if(online_ofline.length){
        //   const online_ofline_str = online_ofline_arr.join();
        //   query += " AND astro.online_status IN("+online_ofline_str+")";
        // }
        // if(price_min && price_max){
        //   query += " AND astro.price_per_mint_video BETWEEN "+price_min+" AND "+price_max;
        // }

        query += orderby+" rv.rate ASC"
    }else if(sort_by == 'ratinghightolow'){
      query = "SELECT astro.* FROM astrologers as astro INNER JOIN reviews as rv ON rv.type_id = astro.id INNER JOIN skills as skills ON skills.user_id = astro.id WHERE astro.status = 1 AND rv.type = 2   AND skills.speciality_id = "+service+" ";

      // if(online_ofline.length){
      //   const online_ofline_str = online_ofline_arr.join();
      //   query += " AND astro.online_status IN("+online_ofline_str+")";
      // }
      // if(price_min && price_max){
      //   query += " AND astro.price_per_mint_video BETWEEN "+price_min+" AND "+price_max;
      // }

      query += orderby+" rv.rate DESC"
    }else{
      
      if(sort_by == 'exhightolow'){
        query += orderby+" astro.experience DESC";
      }
      else if(sort_by == 'exlowtohigh'){
        query += orderby+" astro.experience ASC";
      }
      else if(sort_by == 'pricelowtohigh'){
        query += orderby+" astro.price_per_mint_video ASC"
      }
      else if(sort_by == 'pricehightolow'){
        query += orderby+" astro.price_per_mint_video DESC"
      }
      // else if(sort_by == 'ratinglowtohigh'){
      //   query += " AND rv.type = 2 INNER JOIN reviews as rv ON rv.type_id = astro.id "+orderby+" rv.rate ASC"
      // }
      // else if(sort_by == 'ratinghightolow'){
      //   query += " AND rv.type = 2 INNER JOIN reviews as rv ON rv.type_id = astro.id "+orderby+" rv.rate DESC"
      // }
      else{
        query += orderby+" astro.id DESC"
      }

    }

  }
  // query += " GROUP BY astro.id"
  const astrologers = await sequelize.query(query, {
    model: Astrologer,
    mapToModel: true // pass true here if you have any mapped fields
  }).then(async (astrologers)=>{
    for (let astrologer of astrologers) {

      const rating = await averageRatingAstrologer(astrologer.id)
      const experties =await astrologerSpecialities(astrologer.id)
      const isfv = await  checkIfFav(astrologer.id,user_id)
      const busy = await  checkIfAstrologerBusyTime(astrologer.id)
      if(busy){
        astrologer.dataValues.online_status=2
      }
      astrologer.dataValues.expertiesData=experties
      astrologer.dataValues.rating=rating
      astrologer.dataValues.is_favourite=isfv?1:0
    }
    return await astrologers;
  })

  return res.json({
    status:true,
    message:'',
    data:astrologers
  })
  
}

const sortDataAstro = async (req,res) => {
  const data = [
    {
      id:1,
      name:'Experience',
      value:'experience',
      is_selected:''
    },
    {
      id:2,
      name:'Rating',
      value:'rating',
      is_selected:''

    },
    {
      id:3,
      name:'Price (low to high)',
      value:'lowtohigh',
      is_selected:''

    },
    {
      id:4,
      name:'Price (high to low)',
      value:'hightolow',
      is_selected:''

    }
  ];

  return res.json(successRes('',data))
}


const check_astrologer_booking_status = async (req,res) => {
  const {user_id} = req.body;
  const dateTime =await currentTimeStamp();

  const booking =await Booking.scope(['astrologer']).findOne({
    where:{
      user_id:user_id,
      status:{
        [Op.in]:[0,1]
      }
    },
    order:[
      ['schedule_date_time','DESC']
    ]
  })

  if(!booking){
    return res.json(failedRes('failed'));
  }else{

    var start_status=0;

    // console.log('schdule',booking.schedule_date_time,'current',dateTime);

    
    if(booking.is_chat_or_video_start==1 || booking.is_chat_or_video_start==2){
      start_status = is_chat_or_video_start;
    }
  

    if(moment(booking.schedule_date_time,'YYYY-MM-DD HH:mm:ss').isSameOrAfter(dateTime)){
      return res.json({
        status:true,
        message:'',
        is_chat_or_video_start:is_chat_or_video_start,
        start_status:start_status,
        channel_id:booking.bridge_id,
        data:booking
      })

    }else{
return res.json(failedRes('failed',booking));
    }


   
  }

}

const initiate_astrologer_booking = async (req,res) => {
  const {user_id}=req.body;
  
  const booking =await Booking.scope(['astrologer']).findOne({
    where:{
      user_id:user_id,
      status:{
        [Op.in]:[0,1]
      }
    },
    order:[
      ['schedule_date_time','ASC']
    ]
  })

  if(!booking){
    return res.json(failedRes('failed'));
  }else{

    await Booking.update({
      is_chat_or_video_start : 2
    },{
      where:{
        id:booking.id
      }
    })
    return res.json(successRes('done'))
  }
}


const get_puja_booking_status = async (req,res) => {
  const {user_id} = req.body;
  var date =await currentTimeStamp('YYY-MM-DD');

  const dateTime = moment(await currentTimeStamp());
  // const dateTime = currentTimeStamp();
  // const dateTime = moment(new Date()).format('YYYY-MMMM-DD HH:mm')
  // console.log('DATE',date);
  // var split = date.split(' ');
  // var d = split[0];
  const booking =await Bookinghistory.findOne({
    where:{
      user_id:user_id,
      mode:'online',
      supervisor_id:{
        [Op.ne]:0
      },
      // is_chat_or_video_start:{
      //   [Op.in]:[1,2]
      // },
      status:{
        [Op.in]:[0,6]
      },
      // schedule_date:d
    },
    order:[
      ['schedule_date_time','ASC']
    ]
  })
  


  if(!booking){
    return res.json(failedRes('failed'));
  }else{

    // if(!moment(currentTimeStamp('YYYY-MM-DD')).isSame(moment(booking.schedule_date_time,'YYYY-MM-DD'))){
    //   return res.json(failedRes('failed',booking));

    // }else{
      
      var start_status=0;

      // console.log('schdule',booking.schedule_date_time,'current',dateTime);

      // if(booking.is_chat_or_video_start==1 || booking.is_chat_or_video_start==2){
      //   // start_status = is_chat_or_video_start;
      // }
      // console.log('time diff ',moment(booking.schedule_date_time,'YYYY-MM-DD HH:mm:ss').diff(dateTime));
      var a =await moment(booking.schedule_date_time,'YYYY-MM-DD HH:ssa');
      var b =await moment(dateTime)
      
      var diff = a.diff(b, 'minutes');
      // console.log('minutes ',diff);

      // console.log(moment()+'  '+moment(booking.schedule_date_time,'YYYY-MM-DD HH:mm:ss'));
      if(diff <= 0){

        const priest =await Priest.findOne({
          where:{
            id:booking.priest_id
          }
        })

        const supervisor =await Supervisor.findOne({
          where:{
            id:booking.supervisor_id
          }
        })

        return res.json({
          status:true,
          message:'',
          supervisor:supervisor,
          priest:priest,
          booking_started_by:booking.booking_started_by,
          channel_id:booking.bridge_id,
          data:booking
        })

      }else{
        return res.json(failedRes('failed',booking));
      }
    // }


  }
}

const join_puja = async (req,res) => {
  const {user_id} = req.body;
  var date =await currentTimeStamp('YYY-MM-DD');

  const dateTime = moment(await currentTimeStamp());
  // const dateTime = currentTimeStamp();
  // const dateTime = moment(new Date()).format('YYYY-MMMM-DD HH:mm')
  console.log('DATE',date);
  // var split = date.split(' ');
  // var d = split[0];
  const booking =await Bookinghistory.findOne({
    where:{
      user_id:user_id,
      mode:'online',
      // supervisor_id:{
      //   [Op.ne]:0
      // },
      is_chat_or_video_start:{
        [Op.in]:[1,2]
      },
      status:{
        [Op.in]:[0,6]
      },
      // schedule_date:d
    },
    order:[
      ['schedule_date_time','ASC']
    ]
  })
  
  if(booking){
    await Bookinghistory.update({
      is_chat_or_video_start:2
    },{
     where:{ id:booking.id }
    })
  }

  return res.json(successRes('done'))
}


const end_puja = async (req,res) => {
  const {user_id} = req.body;

  const booking =await Bookinghistory.findOne({
    where:{
      user_id:user_id,
      status:{
        [Op.in]:[0,6]
      }
    },
    order:[
      ['schedule_date_time','DESC']
    ]
  })

  if(!booking){
    return res.json(failedRes('failed'));
  }else{

    await Bookinghistory.update({
      status:1
    },{
      where:{
        id:booking.id
      }
    })
  }

  return res.json(successRes('success',booking));
}

const callback_for_live_booking_check =async (abooking,milliseconds,wallet_deduct) => {
  const dateTime = moment(await currentTimeStamp());
  const dateTime1 = await currentTimeStamp();
  const booking = await Booking.findOne({
    where:{
      id:abooking.id,
      status:{
        [Op.in]:[0,1]
      },
    },
    order:[['id','asc']]
  })
  if(booking && booking.is_paid != 1){
    const user = User.findOne({
      where:{
        id:booking.user_id,
      }
    })
    var old_wallet = parseFloat(user.wallet);
    var txn_amount =  wallet_deduct;
    var new_wallet = old_wallet-txn_amount;
    if(new_wallet<0){
      new_wallet=0;
    }
    var txn_type = 'debit';
    const txn_id = GenerateUniqueID()+user_id;
    var transactiondata = {
      user_id:user_id,
      booking_id:booking.id,
      txn_name:'Astrologer Booking',

      payment_mode:'wallet',
      booking_txn_id:txn_id,
      txn_for:'booking',
      type:txn_type,
      old_wallet:old_wallet,
      txn_amount:txn_amount,
      update_wallet:new_wallet,
      status:1,
      created_at:dateTime1,
      updated_at:dateTime1
    };

    var a = moment(booking.schedule_date_time,'YYYY-MM-DD HH:ssa');
    var b = moment(dateTime)
    var diff = Math.abs(a.diff(b, 'minutes'));

    // var diffseconds = Math.abs(a.diff(b, 'minutes'));
    if(diff == 0){
      diff=1;
    }

    const t = await sequelize.transaction();
    try {
      await Booking.update({
        status:2,
        is_paid:1,
        end_time:dateTime1,
        total_minutes:diff,
        time_minutes:diff,
        txn_id:txn_id
      },{
        where:{
          id:astrobooking.id,
          status : {
            [Op.in]:[0,1]
          }
        }
      }, { transaction: t })

      await User.update({
        wallet:new_wallet
      },{
        where:{
          id:user_id
        }
      },  { transaction: t })
      await Transaction.create(transactiondata
        , { transaction: t });
      await t.commit();
      // return res.json(successRes('done!!',dt))
    }catch (error) {
      // If the execution reaches this line, an error was thrown.
      // We rollback the transaction.
      await t.rollback();
      // return res.json(failedRes('failed!!'));
    }
  }

return true;
}
const GenerateUniqueID = function () {
  // Math.random should be unique because of its seeding algorithm.
  // Convert it to base 36 (numbers + letters), and grab the first 9 characters
  // after the decimal.
  return  Math.random().toString(36).substr(2, 9);
};
const booking_status_function_olld = async (user_id) => {
  /**current_time */

  const dateTime = moment(await currentTimeStamp());

  const checkIfLiveBooking = await Bookingrequest.findOne({
    where:{
      user_id:user_id,
      status:{
        [Op.in]:[0,1]
      },
    },
    order:[
      ['id','desc']
    ]
  })
  if(checkIfLiveBooking){
    if(checkIfLiveBooking.status == 1){
      const astrobooking =await Booking.scope(['astrologer']).findOne({
        where:{
          user_id:user_id,
          is_premium:0,
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
      });
      if(astrobooking){

        const astrologer = await Astrologer.findOne({
          where:{
            id:astrobooking.assign_id
          }
        })

        // if(astrologer.status ==0 || astrologer.status == 1){
        //   astrologer.b
        // }


        astrobooking.dataValues.name = astrologer.name;
        astrobooking.dataValues.astrologer = astrologer;
        astrobooking.dataValues.status_txt = "Accepted";

        var total_minutes = astrobooking.total_minutes;

        var a = moment(astrobooking.schedule_date_time);
        console.log('a',a);

        var b = moment(dateTime)
        console.log('b',b);

        var diff = a.diff(b, 'minutes');

        if(diff <= 0){
          const time_minutes = parseInt(total_minutes) ;
          const secondsDiff = Math.abs(a.diff(b, 'seconds'));
          const time_seconds = time_minutes*60;
          const start_min_seconds = Math.abs(secondsDiff);
          const remaining_time_seconds = time_seconds - start_min_seconds;
          console.log('remaining_time_seconds',remaining_time_seconds);

          if(remaining_time_seconds <= 0 ){

            return (failedRes('failed'))
          }else{
            const astrologer = await Astrologer.findOne({
              where:{
                id:astrobooking.assign_id
              }
            })

              astrobooking.dataValues.remaining_time = remaining_time_seconds
              astrobooking.dataValues.name = astrologer.name;
              astrobooking.dataValues.astrologer = astrologer;
              astrobooking.dataValues.status_txt = "Accepted";

            return ({
              status:true,
              message:'',
              data:astrobooking
            })
          }
  
        }else{
          // return await booking_status_puja_schdule_astrologer(user_id)
          return (failedRes('failed'))

        }
      }
      else{
        // var data =await booking_status_puja_schdule_astrologer(user_id)
        // return data;
        return (failedRes('failed'))

      }
    }else if(checkIfLiveBooking.status == 0){
      const astrologer = await Astrologer.findOne({
        where:{
          id:checkIfLiveBooking.astrologer_id
        }
      })
      checkIfLiveBooking.dataValues.name = astrologer.name
      checkIfLiveBooking.dataValues.astrologer = astrologer
      checkIfLiveBooking.dataValues.status_txt = "Pending"
      checkIfLiveBooking.dataValues.is_premium = 0;
      checkIfLiveBooking.dataValues.booking_type = 2;
      return ({
        status:true,
        message:'',
        astrologer:astrologer,
        data:checkIfLiveBooking
      })
    }else{
      // return await booking_status_puja_schdule_astrologer(user_id)
      return (failedRes('failed'))

    }
  }else{
    // return await booking_status_puja_schdule_astrologer(user_id)
    return (failedRes('failed'))

  }
}


const booking_status_function = async (user_id) => {
  /**current_time */

  const dateTime = moment(await currentTimeStamp());

  const checkIfLiveBooking = await Bookingrequest.findOne({
    where:{
      user_id:user_id,
      status:{
        [Op.in]:[0,1]
      },
    },
    order:[
      ['id','desc']
    ]
  })
  if(checkIfLiveBooking){
    if(checkIfLiveBooking.status == 1){
      const astrobooking =await Booking.scope(['astrologer']).findOne({
        where:{
          user_id:user_id,
          is_premium:0,
          status:{
            [Op.in]:[0,1,6]
          },
          type:{
            [Op.in]:[1,2,3]
          },
        },
        order:[
          ['id','asc']
        ]
      });
      if(astrobooking){

        const astrologer = await Astrologer.findOne({
          where:{
            id:astrobooking.assign_id
          }
        })

        


        astrobooking.dataValues.name = astrologer.name;
        astrobooking.dataValues.astrologer = astrologer;
        astrobooking.dataValues.status_txt = "Accepted";
        astrobooking.dataValues.is_accepted =await astrobooking.status==6?1:0;

        var total_minutes = astrobooking.total_minutes;

        var a = moment(astrobooking.schedule_date_time);
        console.log('a',a);

        var b = moment(dateTime)
        console.log('b',b);

        var diff = a.diff(b, 'minutes');

        if(diff <= 0){
          const time_minutes = parseInt(total_minutes) ;
          const secondsDiff = Math.abs(a.diff(b, 'seconds'));
          const time_seconds = time_minutes*60;
          const start_min_seconds = Math.abs(secondsDiff);
          const remaining_time_seconds = time_seconds - start_min_seconds;
          console.log('remaining_time_seconds',remaining_time_seconds);

          if(remaining_time_seconds <= 0 && astrologer.status == 6){

            return (failedRes('failed'))
          }else{
            const astrologer = await Astrologer.findOne({
              where:{
                id:astrobooking.assign_id
              }
            })

              astrobooking.dataValues.remaining_time = remaining_time_seconds
              astrobooking.dataValues.name = astrologer.name;
              astrobooking.dataValues.astrologer = astrologer;
              astrobooking.dataValues.status_txt = "Accepted";
             

            return ({
              status:true,
              message:'',
              data:astrobooking
            })
          }
  
        }else{
          // return await booking_status_puja_schdule_astrologer(user_id)
          return (failedRes('failed'))

        }
      }
      else{
        // var data =await booking_status_puja_schdule_astrologer(user_id)
        // return data;
        return (failedRes('failed'))

      }
    }else if(checkIfLiveBooking.status == 0){
      const astrologer = await Astrologer.findOne({
        where:{
          id:checkIfLiveBooking.astrologer_id
        }
      })
      checkIfLiveBooking.dataValues.is_accepted = 2;
      checkIfLiveBooking.dataValues.name = astrologer.name
      checkIfLiveBooking.dataValues.astrologer = astrologer
      checkIfLiveBooking.dataValues.status_txt = "Pending"
      checkIfLiveBooking.dataValues.is_premium = 0;
      checkIfLiveBooking.dataValues.booking_type = 2;
      return ({
        status:true,
        message:'',
        astrologer:astrologer,
        data:checkIfLiveBooking
      })
    }else{
      // return await booking_status_puja_schdule_astrologer(user_id)
      return (failedRes('failed'))

    }
  }else{
    // return await booking_status_puja_schdule_astrologer(user_id)
    return (failedRes('failed'))

  }
}


const booking_status_puja_schdule_astrologer = async (user_id) => {
  console.log('fjfjfj')
  const dateTime = moment(await currentTimeStamp());
  // const TODAY_START = new Date().setHours(0, 0, 0, 0);
  // const NOW = new Date();
  const todaydate = currentTimeStamp('YYYY-MM-DD')
  // console.log('NOW',NOW, 'TODAY_START ',TODAY_START)

  console.log('puja_astr',dateTime)
  const end_time = currentTimeStamp();
    const booking =await Bookinghistory.findOne({
      where:{
        user_id:user_id,
        mode:'online',
        supervisor_id:{
          [Op.ne]:0
        },
        status:{
          [Op.in]:[0,6]
        },
        schedule_date_time:{
          [Op.gt]: todaydate+' 00:00:00',
          [Op.lt]: todaydate+' 24:00:00'
        }
      },
      order:[
        ['schedule_date_time','ASC']
      ]
    })
  
  
    if(!booking){ /**check astrologer booking */
      const astrobooking =await Booking.scope(['astrologer']).findOne({
        where:{
          user_id:user_id,
          status:{
            [Op.in]:[0,1]
          },
          type:{
            [Op.in]:[1,2,3]
  
          },
          schedule_date_time:{
            [Op.gt]: todaydate+' 00:00:00',
            [Op.lt]: todaydate+' 24:00:00'
          },
          is_premium:1
        }
      })
      if(astrobooking){
        var a = moment(astrobooking.schedule_date_time,'YYYY-MM-DD HH:ssa');
        var b = moment(dateTime)
        var diff = a.diff(b, 'minutes');
        console.log('minutes ',diff);
    
        if(diff <= 0){
          const time_minutes = parseInt(astrobooking.time_minutes) ;
          const start_min = Math.abs(diff);
          const remaining_time = time_minutes - start_min;
          // console.log('seconds diff',a.diff(b, 'seconds'));
          const secondsDiff = a.diff(b, 'seconds');
          const time_seconds = time_minutes*60;
          const start_min_seconds = Math.abs(secondsDiff);
          const remaining_time_seconds = time_seconds - start_min_seconds;
  
          if(remaining_time_seconds <= 0 ){
            await Booking.update({
              status:2,
              end_time:end_time,
              // time_minutes:time_minutes,
            },{
              where:{
                id:astrobooking.id,
                status : {
                  [Op.in]:[0,1]
                }
              }
            })
            return (failedRes('failed'))
  
          }else{
            const astrologer = await Astrologer.findOne({
              where:{
                id:astrobooking.assign_id
              }
            })
            astrobooking.dataValues.name = astrologer.name
            astrobooking.dataValues.astrologer = astrologer
            astrobooking.dataValues.remaining_time = remaining_time_seconds
            astrobooking.dataValues.status_txt = "Started";
            return ({
              status:true,
              message:'',
              type:'astrologer',
              astrologer:astrologer,
              channel_id:astrobooking.bridge_id,
              data:astrobooking
            })
          }
  
        }else{
          return (failedRes('failed',astrobooking));
        }
      }
      return (failedRes('failed',astrobooking));
  
    }else{ /** puja booking */
        var start_status=0;
  
        console.log('schdule',booking.schedule_date_time,'current',dateTime);
        booking.dataValues.booking_type=1;
        var a = moment(booking.schedule_date_time,'YYYY-MM-DD HH:ssa');
        var b = moment(dateTime)
        var diff = a.diff(b, 'minutes');
        console.log('minutes ',diff);
  
        if(diff <= 0){
  
          const priest =await Priest.findOne({
            where:{
              id:booking.priest_id
            }
          })
  
          const supervisor =await Supervisor.findOne({
            where:{
              id:booking.supervisor_id
            }
          })
  
          return ({
            status:true,
            message:'',
            type:'puja',
            supervisor:supervisor,
            priest:priest,
            booking_started_by:booking.booking_started_by,
            channel_id:booking.bridge_id,
            data:booking
          })
  
        }else{
  
          const astrobooking =await Booking.scope(['astrologer']).findOne({
            where:{
              user_id:user_id,
              status:{
                [Op.in]:[0,1]
              },
              type:{
                [Op.in]:[1,2,3]
      
              },
              schedule_date_time:{
                [Op.gt]: todaydate+' 00:00:00',
                [Op.lt]: todaydate+' 24:00:00'
              },
              is_premium:1
            }
          })
          if(astrobooking){
            var a = moment(astrobooking.schedule_date_time,'YYYY-MM-DD HH:ssa');
            var b = moment(dateTime)
            var diff = a.diff(b, 'minutes');
            console.log('minutes ',diff);
        
            if(diff <= 0){
              console.log('seconds diff 2',a.diff(b, 'seconds'));
              const secondsDiff = a.diff(b, 'seconds');
        
              const time_minutes = parseInt(astrobooking.time_minutes);
              const start_min = Math.abs(diff);
              const remaining_time = time_minutes - start_min;
  
              const time_seconds = time_minutes*60;
              const start_min_seconds = Math.abs(secondsDiff);
              const remaining_time_seconds = time_seconds - start_min_seconds;
  
              if(remaining_time_seconds <=  0 ){
                await Booking.update({
                  status:2,
                  end_time:end_time,
                  // total_minutes:time_minutes,
                },{
                  where:{
                    id:astrobooking.id,
                    status : {
                      [Op.in]:[0,1]
                    }
                  }
                })
                return (failedRes('failed'))
      
              }else{
                const astrologer = await Astrologer.findOne({
                  where:{
                    id:astrobooking.assign_id
                  }
                })
                astrobooking.dataValues.name = astrologer.name
                astrobooking.dataValues.astrologer = astrologer
                astrobooking.dataValues.remaining_time = remaining_time_seconds
                astrobooking.dataValues.status_txt = "Started";
      
                return ({
                  status:true,
                  message:'',
                  type:'astrologer',
                  astrologer:astrologer,
                  channel_id:astrobooking.bridge_id,
                  data:astrobooking
                })
              }
      
        
            }else{
              return (failedRes('failed',astrobooking));
            }
          }
          return (failedRes('failed',booking));
        }
    }
  
}


const booking_status_function_old =async (user_id) => {
  var date = currentTimeStamp('YYY-MM-DD');
  // const date = formatDate(new Date());
  // const date = moment().format('YYYY-MM-DD');
  const dateTime = moment(await currentTimeStamp());

  const user =await User.findOne({
    attributes:['wallet'],
    where:{
      id:user_id
    }
  })

  const user_wallet = parseFloat(user.wallet);

  const checkIfLiveBooking = await Bookingrequest.findOne({
    where:{
      user_id:user_id
    },
    status:{
      [Op.in]:[0,1]
    },
    order:[
      ['id','desc']
    ]
  })
  if(checkIfLiveBooking){
    console.log('live_booking' ,checkIfLiveBooking);
    if(checkIfLiveBooking.status == 1){
      const astrobooking =await Booking.scope(['astrologer']).findOne({
        where:{
          user_id:user_id,
          is_premium:0,
          status:{
            [Op.in]:[0,1]
          },
          type:{
            [Op.in]:[1,2,3]
  
          }
        }
      });
      // console.log('astro3635',astrobooking);
      if(astrobooking){
        const astrologer = await Astrologer.findOne({
          where:{
            id:astrobooking.assign_id
          }
        })
        astrobooking.dataValues.name = astrologer.name
        astrobooking.dataValues.astrologer = astrologer
        astrobooking.dataValues.status_txt = "Accepted"
        var price_per_mint_chat =parseFloat(astrobooking.subtotal);
        console.log(price_per_mint_chat);
        var total_minutes = Math.round(user_wallet/price_per_mint_chat);

        var a = moment(astrobooking.schedule_date_time,'YYYY-MM-DD HH:ssa');
        var b = moment(dateTime)
        var diff = a.diff(b, 'minutes');
        console.log('minutes ',diff);

        console.log('total_minutes',total_minutes);
        if(diff <= 0){
          const time_minutes = parseInt(total_minutes) ;
          const start_min = Math.abs(diff);
          const remaining_time = time_minutes - start_min;
          const secondsDiff = a.diff(b, 'seconds');
          const time_seconds = time_minutes*60;
          const start_min_seconds = Math.abs(secondsDiff);
          console.log('seconds',start_min_seconds);
          const remaining_time_seconds = time_seconds - start_min_seconds;

          if(remaining_time_seconds <= 0 ){
            var old_wallet = parseFloat(user.wallet);
            var txn_amount =  parseFloat(price_per_mint_chat*total_minutes);
            var new_wallet = old_wallet-txn_amount;
            var txn_type = 'debit';
            const txn_id = moment().utc()+user_id;
            var transactiondata = {
              user_id:user_id,
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
            const t = await sequelize.transaction();
            try {
              await Booking.update({
                status:2,
                end_time:currentTimeStamp(),
                total_minutes:total_minutes,
                time_minutes:total_minutes,
                txn_id:txn_id

              },{
                where:{
                  id:astrobooking.id,
                  status : {
                    [Op.in]:[0,1]
                  }
                }
              }, { transaction: t })

              await User.update({
                wallet:new_wallet
              },{
                where:{
                  id:user_id
                }
              },  { transaction: t })
              const dt = await Transaction.create(transactiondata
                , { transaction: t });
              await t.commit();
              // return res.json(successRes('done!!',dt))
            }catch (error) {
              // If the execution reaches this line, an error was thrown.
              // We rollback the transaction.
              await t.rollback();
              // return res.json(failedRes('failed!!'));
            }
            return (failedRes('failed'))
          }else{
            const astrologer = await Astrologer.findOne({
              where:{
                id:astrobooking.assign_id
              }
            })
            astrobooking.dataValues.name = astrologer.name
            astrobooking.dataValues.astrologer = astrologer
            astrobooking.dataValues.remaining_time = remaining_time_seconds
  
            return ({
              status:true,
              message:'',
              type:'astrologer',
              astrologer:astrologer,
              channel_id:astrobooking.bridge_id,
              data:astrobooking
            })
          }
  
        }else{
          return (failedRes('failed',astrobooking));
        }
      }
    }else if(checkIfLiveBooking.status == 0){
        var a = moment(checkIfLiveBooking.accept_date,'YYYY-MM-DD HH:ssa');
        var b = moment(dateTime)
        // var diffmin = a.diff(b, 'minutes');
        // if(diffmin > 2){
          //  Bookinghistory.destroy({
          //   id:checkIfLiveBooking.id
          // })
        // }

      // const astrobooking =await Booking.scope(['astrologer']).findOne({
      //   where:{
      //     user_id:user_id,
      //     is_premium:0,
      //     status:{
      //       [Op.in]:[0,1]
      //     },
      //     type:{
      //       [Op.in]:[1,2,3]
  
      //     }
      //   }
      // });
      // if(astrobooking){
        // var astrobooking={};
        const astrologer = await Astrologer.findOne({
          where:{
            id:checkIfLiveBooking.astrologer_id
          }
        })
        checkIfLiveBooking.dataValues.name = astrologer.name
        checkIfLiveBooking.dataValues.astrologer = astrologer
        checkIfLiveBooking.dataValues.status_txt = "Pending"
        checkIfLiveBooking.dataValues.is_premium = 0;
        checkIfLiveBooking.dataValues.booking_type = 2;



        return ({
          status:true,
          message:'',
          astrologer:astrologer,
          // channel_id:astrobooking.bridge_id,
          data:checkIfLiveBooking
        })
      }else{
        return res.json(failedRes('failed'))
      }
    // }
  }else{
    const booking =await Bookinghistory.findOne({
      where:{
        user_id:user_id,
        mode:'online',
        supervisor_id:{
          [Op.ne]:0
        },
        status:{
          [Op.in]:[0,6]
        },
      },
      order:[
        ['schedule_date_time','ASC']
      ]
    })
  
  
    if(!booking){ /**check astrologer booking */
      const astrobooking =await Booking.scope(['astrologer']).findOne({
        where:{
          user_id:user_id,
          status:{
            [Op.in]:[0,1]
          },
          type:{
            [Op.in]:[1,2,3]
  
          }
        }
      })
      if(astrobooking){
        var a = moment(astrobooking.schedule_date_time,'YYYY-MM-DD HH:ssa');
        var b = moment(dateTime)
        var diff = a.diff(b, 'minutes');
        console.log('minutes ',diff);
    
        if(diff <= 0){
          const time_minutes = parseInt(astrobooking.time_minutes) ;
          const start_min = Math.abs(diff);
          const remaining_time = time_minutes - start_min;
          // console.log('seconds diff',a.diff(b, 'seconds'));
          const secondsDiff = a.diff(b, 'seconds');
          const time_seconds = time_minutes*60;
          const start_min_seconds = Math.abs(secondsDiff);
          const remaining_time_seconds = time_seconds - start_min_seconds;
  
          if(remaining_time_seconds <= 0 ){
            await Booking.update({
              status:2,
              end_time:currentTimeStamp(),
              // time_minutes:time_minutes,
            },{
              where:{
                id:astrobooking.id,
                status : {
                  [Op.in]:[0,1]
                }
              }
            })
            return (failedRes('failed'))
  
          }else{
            const astrologer = await Astrologer.findOne({
              where:{
                id:astrobooking.assign_id
              }
            })
            astrobooking.dataValues.name = astrologer.name
            astrobooking.dataValues.astrologer = astrologer
            astrobooking.dataValues.remaining_time = remaining_time_seconds
  
            return ({
              status:true,
              message:'',
              type:'astrologer',
              astrologer:astrologer,
              channel_id:astrobooking.bridge_id,
              data:astrobooking
            })
          }
  
        }else{
          return (failedRes('failed',astrobooking));
        }
      }
      return (failedRes('failed',astrobooking));
  
    }else{ /** puja booking */
        var start_status=0;
  
        console.log('schdule',booking.schedule_date_time,'current',dateTime);
  
        var a = moment(booking.schedule_date_time,'YYYY-MM-DD HH:ssa');
        var b = moment(dateTime)
        var diff = a.diff(b, 'minutes');
        console.log('minutes ',diff);
  
        if(diff <= 0){
  
          const priest =await Priest.findOne({
            where:{
              id:booking.priest_id
            }
          })
  
          const supervisor =await Supervisor.findOne({
            where:{
              id:booking.supervisor_id
            }
          })
  
          return ({
            status:true,
            message:'',
            type:'puja',
            supervisor:supervisor,
            priest:priest,
            booking_started_by:booking.booking_started_by,
            channel_id:booking.bridge_id,
            data:booking
          })
  
        }else{
  
          const astrobooking =await Booking.scope(['astrologer']).findOne({
            where:{
              user_id:user_id,
              status:{
                [Op.in]:[0,1]
              },
              type:{
                [Op.in]:[1,2,3]
      
              }
            }
          })
          if(astrobooking){
            var a = moment(astrobooking.schedule_date_time,'YYYY-MM-DD HH:ssa');
            var b = moment(dateTime)
            var diff = a.diff(b, 'minutes');
            console.log('minutes ',diff);
        
            if(diff <= 0){
              console.log('seconds diff 2',a.diff(b, 'seconds'));
              const secondsDiff = a.diff(b, 'seconds');
        
              const time_minutes = parseInt(astrobooking.time_minutes);
              const start_min = Math.abs(diff);
              const remaining_time = time_minutes - start_min;
  
              const time_seconds = time_minutes*60;
              const start_min_seconds = Math.abs(secondsDiff);
              const remaining_time_seconds = time_seconds - start_min_seconds;
  
              if(remaining_time_seconds <=  0 ){
                await Booking.update({
                  status:2,
                  end_time:currentTimeStamp(),
                  // total_minutes:time_minutes,
                },{
                  where:{
                    id:astrobooking.id,
                    status : {
                      [Op.in]:[0,1]
                    }
                  }
                })
                return (failedRes('failed'))
      
              }else{
                const astrologer = await Astrologer.findOne({
                  where:{
                    id:astrobooking.assign_id
                  }
                })
                astrobooking.dataValues.name = astrologer.name
                astrobooking.dataValues.astrologer = astrologer
                astrobooking.dataValues.remaining_time = remaining_time_seconds
      
                return ({
                  status:true,
                  message:'',
                  type:'astrologer',
                  astrologer:astrologer,
                  channel_id:astrobooking.bridge_id,
                  data:astrobooking
                })
              }
      
        
            }else{
              return (failedRes('failed',astrobooking));
            }
          }
          return (failedRes('failed',booking));
        }
    }
  }
  
}



const end_live_session = async (req,res) => {
  const {user_id,booking_id} = req.body;
  const response = await end_live_session_function(user_id,booking_id)
  res.json(response);
}


const end_live_session_function =async (user_id,booking_id) => {
  const dateTime = moment(await currentTimeStamp());
  const end_time = currentTimeStamp();
  const user = await User.findOne({
    where:{id:user_id}
  })

  const booking = await Booking.findOne({
    where:{
      id:booking_id,
      user_id:user_id,
      status:{
        [Op.in]:[0,1,6]
      }
    }
  })
  var booking_type='';

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

      var price_per_mint_chat =parseFloat(booking.price_per_mint);
      const user_wallet = parseFloat(user.wallet);
      // var a = moment(booking.schedule_date_time,'YYYY-MM-DD HH:ssa');
      var a = moment(booking.schedule_date_time);

      var b = moment(dateTime)
      var diffinseconds = Math.abs(a.diff(b, 'seconds'));
      var diff=1;
      // var diffseconds = Math.abs(a.diff(b, 'minutes'));
      

      var diffinminutes = Math.ceil(diffinseconds/60);
      if(diffinminutes > 0){
        diff=diffinminutes;
      }

      var old_wallet = parseFloat(user_wallet);
      var txn_amount =  parseFloat(price_per_mint_chat*diff);
      var new_wallet = old_wallet-txn_amount;
      var txn_type = 'debit';
      const txn_id = GenerateUniqueID()+user_id;

      var transactiondata = {
        user_id:user_id,
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
        const booking2 = await Booking.findOne({
          where:{
            id:booking_id,
            user_id:user_id,
            status:{
              [Op.in]:[0,1,6]
            }
          }
        })
        if(booking2){
          await Booking.update({
            status:2,
            end_time:end_time,
            total_minutes:diff,
            time_minutes:diff,
            payable_amount:txn_amount,
            total_seconds:Math.round(diffinseconds),
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
              id:user_id
            }
          },  { transaction: t })
          const dt = await Transaction.create(transactiondata
            , { transaction: t });
          await t.commit();

          send_booking_complete_notification(b_type,user_id,booking.assign_id,booking_id,txn_amount);
          set_astrologer_comission_to_order(booking_id)

          return (successRes('done!!',booking))
        }else{
          return (failedRes('failed!!'));
        }
      }catch (error) {
        // If the execution reaches this line, an error was thrown.
        // We rollback the transaction.
        await t.rollback();
        return (failedRes('failed!!'));
      }
  }
}  

const set_astrologer_comission_to_order = async (booking_id) => {
  const booking = await Booking.findOne({
    where:{
      id:booking_id
    }
  })
  if(booking){
    const astrologer_id = booking.assign_id;
    const astrologer = await Astrologer.findOne({
      where:{
        id:astrologer_id
      }
    })
    if(astrologer){
      const share_percentage = parseFloat(astrologer.share_percentage);
      if(share_percentage){
        var commision = Math.round((parseFloat(booking.payable_amount))*(share_percentage/100));
        return await Booking.update({
          astrologer_comission_perct:share_percentage,
          astrologer_comission_amount:commision
        },{
          where:{
            id:booking.id
          }
        })


      }else{
        return false;
      }
    }else{
      return false;
    }
  }else{
    return false;
  }
}

const get_booking_status = async (req,res) => {
  const {user_id} = req.body;
  const data = await booking_status_function(user_id)
  return await res.json(data)
}

const add_review = async (req,res) => {

  const {user_id , type , type_id, booking_id, rate, message} = req.body;
  const dateTime =await currentTimeStamp();

  const storeData = {
    booking_id,
    user_id,
    type,
    type_id,
    rate,
    message,
    status:1,
    created_at:dateTime
  }
  await Review.create(storeData)
  .then((rs)=>{
    res.json(successRes('',rs))
  })
  .catch((err)=>{
    res.json(failedRes('failed'))
  })

}

const send_request = async (req,res) => {
  const {user_id, astrologer_id, price_per_mint,type} = req.body;
  const check = await Bookingrequest.findOne({
    where:{
      status:{
        [Op.in]:[0]
      },
      user_id:user_id,
      astrologer_id:astrologer_id,
      type:type
    },
    order:[['id','desc']],
  });

  const dateTime = currentTimeStamp();
  if(check){
    const updateDatA = {
      price_per_mint:price_per_mint,
      created_at:dateTime
    };
     Bookingrequest.update(updateDatA,{
      where:{
        id:check.id
      }
    })
    socket.emit('astrologer_realtimebook',successRes('done',check))
  }else{
    const storeData = {
      user_id:user_id,
      astrologer_id:astrologer_id,
      price_per_mint:price_per_mint,
      status:0,
      type,
      created_at:dateTime
    };
    await Bookingrequest.create(storeData)
    .then(async (rs)=>{

      socket.emit('astrologer_realtimebook',successRes('done',rs))
    })
    .catch((err)=>socket.emit('astrologer_realtimebook',failedRes('failed',err)))
  }
}


const astrokul_home = async (req,res) => {
  const services = await Speciality.scope(["service", "active"]).findAll({ order: [["name", "asc"]] });

  const banners = await Banner.scope(['active','main','orderAsc']).findAll();

  const online_astrologers = await Astrologer.findAll({
    limit:5,
    where:{
      online_status:1
    }
  }).then(async (astrologers) => {
    for (let astrologer of astrologers) {
      const rating = await averageRatingAstrologer(astrologer.id)
      astrologer.dataValues.rating=rating
      const busy = await  checkIfAstrologerBusyTime(astrologer.id)
      if(busy){
        astrologer.dataValues.online_status=2
      }
    }
    return await astrologers;
  })

  const speciality_astrologers = await Speciality.scope(["speciality"]).findAll({limit: 20, order: [["name", "asc"]]})
  .then(async (data) => {
    for (let element of data) {
      await Astrologer.belongsTo(Skill, { targetKey: "user_id", foreignKey: "id" });
      const ast= await Astrologer.findAll({
        limit:5,
        include: [
          {
            model: Skill,
            where: {
              speciality_id: element.id,
            },
          },
        ],
      }).then(async (astrologers) => {
        for (let astrologer of astrologers) {
          const rating = await averageRatingAstrologer(astrologer.id)
          astrologer.dataValues.rating=rating
          const busy = await  checkIfAstrologerBusyTime(astrologer.id)
          if(busy){
            astrologer.dataValues.online_status=2
          }
        }
        return await astrologers;
      })
      element.dataValues.astrologers= ast;
    }
    return await data;
  })
  return res.json({
    status:true,
    services,
    banners,
    online_astrologers,
    speciality_astrologers
  })
}


const fetch_astrologer_by_speciality_services = async (req,res) => {

  var {limit,offset,id,can_take_horoscope,user_id} = req.body;
  if(!user_id){
    user_id=0;
  }
  if (!offset) {
    offset = 0;
  }
  if (!limit) {
    limit = 10;
  }

  var whereObj={};
  if(can_take_horoscope){
    whereObj={
    }
  }else{
    whereObj={
      can_take_horoscope:1
    }
  }

  Astrologer.belongsTo(Skill, { targetKey: "user_id", foreignKey: "id" });
  const ast= await Astrologer.findAll({
    where:whereObj,
    limit: limit,
    offset: offset,
    include: [
      {
        model: Skill,
        where: {
          speciality_id:id,
        },
      },
    ],
  }).then(async (astrologers) => {
    for (let astrologer of astrologers) {


      const rating = await averageRatingAstrologer(astrologer.id)
      const experties =await astrologerSpecialities(astrologer.id)
      const isfv = await  checkIfFav(astrologer.id,user_id)
      // const busy = await  checkIfAstrologerBusyTime(astrologer.id)
      // if(busy){
      //   astrologer.dataValues.online_status=2
      // }
      const busy = await  checkIfAstrologerBusyTime(astrologer.id)
      if(busy){
        astrologer.dataValues.online_status=2
      }
      astrologer.dataValues.expertiesData=experties
      astrologer.dataValues.rating=rating
      astrologer.dataValues.is_favourite=isfv?1:0
      
    }
    return await astrologers;
  })

  return res.json({
    status:true,
    limit,
    offset,
    data:ast
  })
}


const fetch_astro_services = async (req,res) => {
  const services = await Speciality.scope(["service", "active"]).findAll({ order: [["name", "asc"]] });

  return res.json(successRes('fetch',services))
}

const fetch_faqs = async (req,res)=>{
  const faqs = await FAQ.scope(['active','orderAsc']).findAll();
  return res.json(successRes('fetch',faqs));
}

const add_support = async (req,res) => {
  const {user_id,name,email,message} = req.body;
  const dateTime = currentTimeStamp();
  const user = await User.findOne({
    where:{
      id:user_id
    }
  })

  const storeData = {
    user_id,
    name,
    email,
    message,
    mobile:user.phone,
    added_on:dateTime
  }
  await Support.create(storeData)
  .then(rs=>res.json(successRes('added',rs)))
  .catch(err=>res.json(failedRes('failed to send,Please try again')))
}




const search_astro_by_filter = async (req,res) =>{
  var {speciality,service,rating,online_ofline,price_min,price_max,sort_by,language,mode,country,gender} = req.body;
  const {user_id} = req.body;
  console.log(req.body);
  var speciality_arr=[];
  var service_arr=[];
  var language_arr=[];
  var language_arr_logic='';
  var online_ofline_arr = [];
  if(service.length>0){
    service_arr = service.split("|");
  }
  if(speciality.length>0){
    speciality_arr = speciality.split("|");
  }

  var whereinstring = speciality_arr.concat(service_arr);
  var uniqueChars = [...new Set(whereinstring)];

  var whereInQuery="";
  if (mode=='chat') {
    whereInQuery = " AND astro.online_consult IN(1,4,5,6) ";
  }else if(mode=='audio'){
    whereInQuery = " AND astro.online_consult IN(3,4,6,7) ";
  }else if(mode == 'video'){
    whereInQuery = " AND astro.online_consult IN(2,4,5,7) ";
  }else if(mode == 'report'){
    whereInQuery = " AND astro.can_take_horoscope=1 "
  }


  var query;
  if(uniqueChars !== '' && uniqueChars && uniqueChars.length>0){
    var wherespser = uniqueChars.join(',')
    query = "SELECT astro.* FROM astrologers as astro INNER JOIN skills as skills ON skills.user_id = astro.id LEFT JOIN reviews as rv ON rv.type_id = astro.id WHERE astro.status = 1 AND astro.approved = 1 AND skills.speciality_id IN ("+wherespser+") "+whereInQuery

  }else{
    query = "SELECT astro.* FROM astrologers as astro LEFT JOIN reviews as rv ON rv.type_id = astro.id WHERE astro.status = 1 AND astro.approved = 1 "+whereInQuery
  }

  if(rating.length>0){
    var operator = '> 0';
    if(rating == 2){
      operator = '> 3';
    }else if(rating == 3){
      operator = '= 5';
    }
    query += " AND rv.rate "+operator;
  }
  if(online_ofline.length>0){
      online_ofline_arr = online_ofline.split("|");
      
    if(online_ofline_arr.length){
      const online_ofline_str = online_ofline_arr.join();
      query += " AND astro.online_status IN("+online_ofline_str+") ";
    }
  }

  var gender_arr=[]
  if(gender && gender !==''){
    query += " AND astro.gender = '"+gender+"' ";
  }

  // if(country && country !==''){
  //   query += " AND astro.country = '"+country+"' ";
  // }

  if(language.length>0){
    language_arr =language.split("|");
    if(language_arr.length){
      const godlnt = language_arr.length;
      language_arr_logic += ' ('
      for (let g = 0; g < godlnt; g++) {

        if(g>0){
          language_arr_logic += ' OR ';
        }
        language_arr_logic += ' astro.languages LIKE "%'+language_arr[g]+'%" '
      }
      language_arr_logic += ') '
      query += ' AND '+language_arr_logic
    }
  }

  if(price_min && price_max){
    query += " AND astro.price_per_mint_video BETWEEN "+price_min+" AND "+price_max;
  }

  query += ' GROUP BY astro.id '
  
  if(sort_by){
    const orderby = " ORDER BY ";

    if(sort_by == 'ratinglowtohigh'){
        query += orderby+" rv.rate ASC"
    }else if(sort_by == 'ratinghightolow'){
      query += orderby+" rv.rate DESC"
    }else{
      
      if(sort_by == 'exhightolow'){
        query += orderby+" astro.experience DESC";
      }
      else if(sort_by == 'exlowtohigh'){
        query += orderby+" astro.experience ASC";
      }
      else if(sort_by == 'pricelowtohigh'){
        if (mode=='chat') {
          query += orderby+" astro.price_per_mint_chat ASC "

        }else if(mode == 'audio'){
          query += orderby+" astro.price_per_mint_audio ASC "
          
        }else{
          query += orderby+" astro.price_per_mint_video ASC "

        }
      }
      else if(sort_by == 'pricehightolow'){
        // query += orderby+" astro.price_per_mint_video DESC"
        if (mode=='chat') {
          query += orderby+" astro.price_per_mint_chat DESC "

        }else if(mode == 'audio'){
          query += orderby+" astro.price_per_mint_audio DESC "
          
        }else{
          query += orderby+" astro.price_per_mint_video DESC "

        }
      }
      else{
        query += orderby+" astro.id DESC"
      }

    }
  }
  try {
    const astrologers = await sequelize.query(query, {
      model: Astrologer,
      mapToModel: true // pass true here if you have any mapped fields
    }).then(async (astrologers)=>{
      if(astrologers){
        const dateTime = moment(currentTimeStamp());
        for (let astrologer of astrologers) {
    
          const rating = await averageRatingAstrologer(astrologer.id)
          // const experties =await astrologerSpecialities(astrologer.id)
          const isfv = 0;
          // const busy = await  checkIfAstrologerBusyTime(astrologer.id)
          // if(busy){
          //   astrologer.dataValues.online_status=2
          // }
          const busy = await  checkIfAstrologerBusyTime(astrologer.id)
          if(busy){
            astrologer.dataValues.online_status=2
            var wait_time=parseFloat(busy.total_minutes)-count_diff_minutes(dateTime,busy.schedule_date_time);
            if(wait_time<0){
              wait_time =0;
            }
            astrologer.dataValues.wait_time=wait_time;
            astrologer.dataValues.queues =await fetch_queue_users_function(astrologer.id);
            const check_queue = await check_if_user_queued(user_id?user_id:0,astrologer.id);
            astrologer.dataValues.is_queued = check_queue?1:0

          }

        
          // var experties_string = '';
          // if(experties && experties.length){
          //   experties_string = experties[0].name
          // }
          astrologer.dataValues.experties_string=astrologer.expertise
          const is_follow =await isFollowAstro(user_id?user_id:0,astrologer.id)
          astrologer.dataValues.is_follow=is_follow?1:0
          
          astrologer.dataValues.expertiesData=[]
          astrologer.dataValues.rating=rating
          astrologer.dataValues.is_favourite=isfv?1:0
        }
      }
      return await astrologers;
    })
  
    return res.json({
      status:true,
      message:'',
      data:astrologers
    })
  } catch (error) {
    return res.json(failedRes('something went wrong',error))
  }

    
}


const broadcast_home = async (req,res) =>{

  var whereObj={};

  var query = "SELECT astro.*,brd.bridge_id,brd.description as broadcast_description FROM astrologers as astro INNER JOIN broadcasts as brd ON brd.astrologer_id=astro.id WHERE brd.status IN(0,1) ORDER BY brd.id ASC";
  const live_astro = await sequelize.query(query, {
    model: Astrologer,
    mapToModel: true // pass true here if you have any mapped fields
  }).then(async (astrologers)=>{
    for (let astrologer of astrologers) {

      const rating = await averageRatingAstrologer(astrologer.id)
      const experties =await astrologerSpecialities(astrologer.id)
      const isfv = 0;
      const busy = await  checkIfAstrologerBusyTime(astrologer.id)
      if(busy){
        astrologer.dataValues.online_status=2
        astrologer.dataValues.wait_time=2
      }
      astrologer.dataValues.expertiesData=experties
      astrologer.dataValues.rating=rating
      astrologer.dataValues.is_favourite=isfv?1:0
    }
    return await astrologers;
  })


    const upcoming_astro =  {}

   
    var query2 = "SELECT astro.*,brd.bridge_id FROM astrologers as astro INNER JOIN broadcasts as brd ON brd.astrologer_id=astro.id WHERE brd.status IN(2) ORDER BY brd.id ASC";
    const history_astro = await sequelize.query(query2, {
      model: Astrologer,
      mapToModel: true // pass true here if you have any mapped fields
    }).then(async (astrologers)=>{
      for (let astrologer of astrologers) {

        const rating = await averageRatingAstrologer(astrologer.id)
        const experties =await astrologerSpecialities(astrologer.id)
        const isfv = 0;
        const busy = await  checkIfAstrologerBusyTime(astrologer.id)
        if(busy){
          astrologer.dataValues.online_status=2
          astrologer.dataValues.wait_time=2
        }
        astrologer.dataValues.expertiesData=experties
        astrologer.dataValues.rating=rating
        astrologer.dataValues.is_favourite=isfv?1:0
      }
      return await astrologers;
    })

    return res.json({
      status:true,
      live_astro,
      upcoming_astro,
      history_astro,
    })

}

const create_broadcast = async (req,res) => {

  const {astrologer_id,title,description,status,start_time,end_time,price,language,gifts_id} = req.body;

  const bridge_id = 'broadcast'+moment().utc();
  const dateTime = currentTimeStamp();

  const check =await Broadcast.findOne({
    where:{
      astrologer_id,
      status:{
        [Op.in]:[0,1]
      }
    }
  })

  if(check){
    return res.json(successRes('create broadcast',check))
  }else{
    var statusinit=0;
    if(start_time && end_time){
      const m_start = moment(start_time);
      const m_end = moment(end_time);
      const tim = moment();
      if (tim.isBetween(m_start, m_end)) {
        statusinit=1;
      }
    }else{
      statusinit = 1;
    }

    const storeData = {
      astrologer_id,
      title,
      description,
      status:statusinit,
      price,
      is_approved:0,
      language,
      bridge_id:bridge_id,
      start_time:start_time,
      gifts_id,
      end_time,
      created_at:dateTime,
    }
    await Broadcast.create(storeData).then((rs)=>{
      send_alert_for_event(rs.id)
      return res.json(successRes('create broadcast',rs))
    })
    .catch((err)=>res.json('failed',err))
  }

}

const end_broadcast = async (req,res) => {
  const {astrologer_id,bridge_id} = req.body;
  const dateTime = currentTimeStamp();
  const check =await Broadcast.findOne({
    where:{
      astrologer_id,
      bridge_id,
      status:{
        [Op.in]:[0,1]
      }
    }
  })

  if(check){

    const count_joiners = await Booking.scope(['orderAsc']).count({
      attributes:['user_id','id','bridge_id'],
      where:{
        bridge_id:bridge_id,
        status:{
          [Op.in]:[0,1,6]
        }
      }
    })
    if(!count_joiners){
      var a = moment(check.start_time);

      var b = moment(dateTime)
      var diffinseconds = Math.abs(a.diff(b, 'seconds'));
      var diffinminutes= Math.abs(a.diff(b, 'minutes'));
  
      const updateData = {
        status:2,
        end_time:dateTime,
        total_minutes:diffinminutes,
        total_seconds:diffinseconds
      }
  
      await Broadcast.update(updateData,{
        where:{
          id:check.id
        }
      }).then(rs=>res.json(successRes('end',rs)))
      .catch((err)=>res.json(failedRes('failed',err)))
    }else{
      return res.json(failedRes('Please complete joiners request',rs))
    }

  }else{
    res.json(failedRes('no any broadcast'));
  }

 
}


const checkIfastrologerfollowed = async (req,res) =>{
  console.log('charan',req.body);
  const {user_id,astrologer_id}=req.body;
  
  const check =await isFollowAstro(user_id,astrologer_id);
  if(check){
    return res.json(successRes('done',check))
  }else{
    return res.json(failedRes('not followed',check));
  }
}

const toggle_follow_astrologer = async (req,res) => {
  const {user_id,astrologer_id} = req.body;
  const dateTime = currentTimeStamp();

  const check =await isFollowAstro(user_id,astrologer_id);
  if(check){
    const dlt = await Follower.destroy({
      where:{
        id:check.id
      }
    })
    if(dlt){
      return res.json({
        status:true,
        message:'unfollowed',
        data:dlt,
        is_followed:0
      })
    }else{
      return res.json(failedRes('failed'))
    }
  }else{
    const storeData = {
      user_id:user_id,
      astrologer_id:astrologer_id,
      created_at:dateTime
    }
    const createdata = await Follower.create(storeData);
    if(createdata){
      return res.json({
        status:true,
        data:createdata,
        message:'followed',
        is_followed:1
      })
    }else{
      res.json(failedRes('failed'))
    }
  }
}


const fetch_astrologer_speciality_horoscope = async (req,res) => {
  const {user_id,astrologer_id} = req.body;
  
  var query = "SELECT ms.*,sk.horoscope_price,sk.id as skill_id FROM master_specialization as ms INNER JOIN skills as sk ON ms.id = sk.speciality_id WHERE sk.status=1 AND sk.user_id="+astrologer_id+" AND sk.give_horoscope=1 ORDER BY ms.name ASC";
  const specialities = await sequelize.query(query, {
    model: Speciality,
    mapToModel: true // pass true here if you have any mapped fields
  })

  res.json(successRes('fetched!',specialities))
}

const astrologer_dynamic = async (req,res) => {
  const {astrologer_id} = req.body;
  if(astrologer_id){
    const data = await astrologer_dynamic_function(astrologer_id);
  return res.json(data);

  }else{
    return res.json(failedRes(''));

  }
}


const astrologer_dynamic_function = async (astrologer_id) =>{
  // console.log('astrologer_dynamic_function');
  const todaydate = currentTimeStamp('YYYY-MM-DD')
    const booking = await Booking.findOne({
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
      }
    })
    const dateTime = currentTimeStamp()

    if(booking){
      const user = await User.findOne({
        where:{
          id:booking.user_id
        }
      })

      var member =await Member.findOne({
          order:[
              ['id','desc']
          ],
          where:{
              user_id:booking.user_id,
          }
      })
      if(!member){
        member={}
      }

      var is_start=0;
      var is_chat_or_video_start=0;
      var booking_id=0;
      var chat_g_id=''
      var user_name = member.name;
      var user_gender = member.gender;
      var user_image = user.imageUrl ;
      const user_wallet=user.wallet;
      var remaining_time=0;
      var request_array=[]
      var booking_type
      var user_id = booking.user_id;
      switch (booking.type) {
        case 1:
          booking_type='video'
          break;
        case 2:
          booking_type='audio'
          break;
        case 3:
          booking_type='chat'
          break;
        default:
          break;
      }
      if(booking.status == 6){
          is_start=1;
          is_chat_or_video_start=1;
          booking_id=booking.id;
          is_booking=1;
          member.dataValues.wallet = user.wallet;
          chat_g_id=booking.bridge_id;
         
          var a = moment(booking.schedule_date_time);  
          var b = moment(dateTime)
          var diff = a.diff(b, 'minutes');
  
          if(diff <= 0){
            const time_minutes = parseInt(booking.total_minutes) ;
            const secondsDiff = Math.abs(a.diff(b, 'seconds'));
            const time_seconds = time_minutes*60;
            const start_min_seconds = Math.abs(secondsDiff);
            const remaining_time_seconds = time_seconds - start_min_seconds;
            member.dataValues.remaining_time =remaining_time_seconds;

            remaining_time=remaining_time_seconds;
            console.log('remaining_time_seconds',remaining_time_seconds);
  
            if(remaining_time_seconds <= 0 && astrologer.status == 6){
              return check_if_any_astrologer_request(astrologer_id)
            }else{
              member.dataValues.remaining_time=remaining_time_seconds;
              const response = {
                status:true,
                is_start,
                is_chat_or_video_start,
                booking_id,
                chat_g_id,
                is_booking,
                user_name,
                user_image,
                user_wallet,
                remaining_time,
                booking_type,
                user_id,
                user_gender,
                request_array,
                user_member:member
              }

              return response
            }
          }else{
            return check_if_any_astrologer_request(astrologer_id)
          }

      }else{
        is_start=0;
        is_chat_or_video_start=0;
        booking_id=booking.id;
        is_booking=1;
        member.dataValues.wallet = user.wallet;
        member.dataValues.remaining_time=0;
        chat_g_id=booking.bridge_id;
        const response = {
          status:true,
          is_start,
          is_chat_or_video_start,
          booking_id,
          chat_g_id,
          is_booking,
          user_name,
          user_image,
          user_wallet,
          remaining_time,
          booking_type,
          user_id,
          user_gender,
          request_array,
          user_member:member
        }

        return response
      }
    }else{
      return check_if_any_astrologer_request(astrologer_id)
    }
}


const check_if_any_astrologer_request = async (astrologer_id) => {
  var check = await Bookingrequest.findOne({
    where:{astrologer_id:astrologer_id,
    status:0}
  })
  if(check){
    var bookcheck=check;
    var member =await Member.findOne({
        where:{
            id:check.member_id,
        }
    })
    const user = await User.findOne({
      where:{
        id:check.user_id
      }
    })

    if(!member){
      member={}
    }
    var is_start=0;
    var is_chat_or_video_start=0;
    var booking_id=0;
    var chat_g_id=0
    var user_name = member.name;
    var user_gender = member.gender;
    var user_image = user.imageUrl ;
    const user_wallet=user.wallet;
    const remaining_time=0;
    console.log('check',check);
    check.dataValues.img=user_image;
    check.dataValues.name=user_name;
    check.dataValues.gender=user_gender;
    check.dataValues.age='';
    var request_array=[]
    var booking_type
    var user_id = check.user_id;
    switch (check.type) {
      case 1:
        booking_type='video'
        break;
      case 2:
        booking_type='audio'
        break;
      case 3:
        booking_type='chat'
        break;
      default:
        break;
    }

    is_start=3;
    is_chat_or_video_start=0;
    booking_id=0;
    is_booking=0;

    member.dataValues.wallet = user.wallet;
    member.dataValues.remaining_time=0;
    const response = {
      status:true,
      is_start,
      is_chat_or_video_start,
      booking_id,
      chat_g_id,
      is_booking,
      user_name,
      user_image,
      user_wallet,
      remaining_time,
      booking_type,
      user_id,
      user_gender,
      request_array:[
        check
      ],
      user_member:member
    }
    return response
  }else{
    return failedRes('failed')
  }
}

const fetch_queue_users_function = async (astrologer_id) => {
  try {
    const bkgs = await Bookingrequest.findAll({
      where:{
        astrologer_id:astrologer_id,
        status:4
      }
    }).then(async (bookings)=>{
      for (let booking of bookings) {
        booking.dataValues.user = await User.findOne({
          attibutes:['id','name','imageUrl','phone','email','wallet'],
          
          where:{
            id:booking.user_id
          }
        })
      }
      return await bookings;
  
    })
    return bkgs;
  } catch (error) {
    return false;
  }
  
}

const fetch_queue_users = async (req,res) => {
  const {astrologer_id}  = req.body;
  const bkgs = await fetch_queue_users_function(astrologer_id)

  res.json(successRes('fetched!',bkgs))


}

const check_if_user_queued =async (user_id,astrologer_id) =>{
  try {
    const data = await Bookingrequest.findOne({where:{astrologer_id:astrologer_id,user_id:user_id,status:4}})
    return data;
  } catch (error) {
    return false;
  }
   
}

const remove_queue = async (req,res) => {
  const {user_id,id} = req.body;
  const deleted = await Bookingrequest.destroy({
    where:{
      id:id
    }
  })
  if(deleted){
    const data = await fetch_user_queue_fun(user_id)
    res.io.sockets.in(user_id).emit('user_queue',data)
    res.json(successRes('removed'))

  }else{
    res.json(failedRes('no queue found!'))

  }

}

// const astrologers = await sequelize.query(query, {
//   model: Astrologer,
//   mapToModel: true // pass true here if you have any mapped fields
// }).then(async (astrologers)=>{
//   for (let astrologer of astrologers) {

//     const rating = await averageRatingAstrologer(astrologer.id)
//     const experties =await astrologerSpecialities(astrologer.id)
//     const isfv = 0;
//     const busy = await  checkIfAstrologerBusyTime(astrologer.id)
//     if(busy){
//       astrologer.dataValues.online_status=2
//     }
//     astrologer.dataValues.expertiesData=experties
//     astrologer.dataValues.rating=rating
//     astrologer.dataValues.is_favourite=isfv?1:0
//   }
//   return await astrologers;
// })

const fetch_settings = async (req,res) => {
  const settings = await Setting.findOne()
  res.json(successRes('',settings))
}

const fetch_user_queue_fun = async (user_id) => {
  // const {user_id} = req.body;
  const queue = await Bookingrequest.findAll({
    where:{
      user_id:user_id,
      status:4
    },
    order:[['id','desc']]
  }).then(async(data)=>{
    const dateTime = moment(currentTimeStamp())
    if(data){
      for (let dt of data) {
        const astrologer = await Astrologer.findOne({
          // attributes:['id','name','imageUrl','phone','email'],
          where:{
            id:dt.astrologer_id
            
          }
        })
        dt.dataValues.astrologer = astrologer;
        const busy = await  checkIfAstrologerBusyTime(dt.astrologer_id)
        if(busy){
          var wait_time=parseFloat(busy.total_minutes)-count_diff_minutes(dateTime,busy.schedule_date_time);
          if(wait_time<0){
            wait_time =0;
          }
          dt.dataValues.wait_time=wait_time;
        }else{
          dt.dataValues.wait_time=0;
        }
      }
    }
    return await data;
  })

  return (queue ?  successRes('',queue) : failedRes(''))
}

const send_test_notification_astro = async (req,res) => {
  const device_token = 'd2boaQRgSSm9KzavJnvNbL:APA91bEQ_oALGEyMM6SHrv7ILIqQeAWO0mZMWwEqcGSxusY16HVjibfJMRlAvEwV5_mUVpA9DfFqJzNZGBg5yZ5v-2_FnUk5IMxP7A2K8hm4xkscSnEp3DIcgkY9icHNvtMSX0wjOCmF';
  send_fcm_push_astrologer(device_token,'Your Call is started with harpreet Singh','Test Notification Message',{astrologer_id:10},'high')
  res.json(successRes(''))
}
module.exports = {
  fetch_explore_banner_puja,
  fetch_explore_yoga_posts,
  fetch_pujas,
  fetch_cities,
  fetch_venues,
  fetch_puja_details,
  time_slots,
  add_guests,
  fetch_explore,
  fetch_astrologer_home,
  fetch_astrologers_on_home,
  fetch_puja_review_locations_details,
  fetch_puja_venues,
  fetch_puja_time_slots,
  add_enquiry,
  fetch_astrologers,
  fetch_astrologer_details,
  fetch_astrologer_time_slots,
  fetch_explore_for_web,
  fetch_tv_posts,
  search_astrologers,
  search_pujas,
  fetch_wallet_and_notification_count,
  fetch_notifications,
  fetch_puja_filters,
  search_puja_by_filters,
  fetch_astrologer_filters,
  search_astrologer_by_filters,
  sortDataAstro,
  check_astrologer_booking_status,
  initiate_astrologer_booking,
  get_puja_booking_status,
  end_puja,
  join_puja,
  get_booking_status,
  booking_status_function,
  end_live_session,
  add_review,
  astrokul_home,
  fetch_astrologer_by_speciality_services,
  fetch_faqs,
  add_support,
  fetch_astro_services,
  search_astro_filter,
  search_astro_by_filter,
  fetch_astrohelp24_home,
  broadcast_home,
  create_broadcast,
  end_broadcast,
  toggle_follow_astrologer,
  checkIfastrologerfollowed,
  fetch_astrologer_speciality_horoscope,
  end_live_session_function,
  set_astrologer_comission_to_order,
  astrologer_dynamic,
  astrologer_dynamic_function,
  fetch_queue_users,
  remove_queue,
  check_if_user_queued,
  fetch_settings,
  fetch_user_queue_fun,
  send_test_notification_astro
};
