const astrogerHelper = require("../helpers/astrologyapi.helper");
const { successRes, failedRes } = require("../helpers/response.helper");
const db = require("../models/index");
const { Horoscope, User } = db;


const fetch_horoscopes = async (req,res) => {
    await Horoscope.scope(['active']).findAll().then((rs)=>res.json(successRes('fetched!!',rs)))
    .catch((err)=>res.json(failedRes('failed',err)))
}


const daily_sun_sign_prediction = async (req,res)=>{
    var {user_id,horoscope} = req.body;

    var req_obj =await astrogerHelper.reqAstroObj(user_id);
    if(req_obj.status){
        await astrogerHelper.sun_sign_prediction_daily(horoscope,req_obj.data).then((rs)=>res.json(rs.data)).catch((err)=>res.json(failedRes(err.message)))
    }
    
    return res.json(failedRes('failed',req_obj.message))
}


const match_making_details = async (req,res)=>{
    var {user_id,
        m_day,
        m_month,
        m_year,
        m_hour,
        m_min,
        m_lat,
        m_lon,
        m_tzone,
        f_day,
        f_month,
        f_year,
        f_hour,
        f_min,
        f_lat,
        f_lon,
        f_tzone
    } = req.body;
    await astrogerHelper
    .match_making_detailed_report(req.body)
    .then((rs)=>res.json(rs.data))
    .catch((err)=>res.json(failedRes(err.message)))
}




module.exports = {
    fetch_horoscopes,
    daily_sun_sign_prediction,
    match_making_details
};
