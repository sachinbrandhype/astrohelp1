

const { successRes, failedRes } = require("../helpers/response.helper");
const { Ropeway, Enquiry } = require("../models/index");
const db = require("../models/index");
const moment = require("moment");
const { currentTimeStamp } = require("../helpers/user.helper");


const fetch_ropeways = async (req,res) => {
    const {user_id} = req.body;
    var {limit,offset}=req.body;
    if (!offset) {
        offset = 0;
    }
    if (!limit) {
        limit = 10;
    }
    const count =await Ropeway.scope(['active']).count();

    await Ropeway.scope(['active']).findAll({
        limit:parseInt(limit),
        offset:parseInt(offset)
    }).then((rs)=>{
        return res.json({
            status:true,
            count,
            limit,
            offset,
            data:rs
        })
    })
}



const fetch_ropeway_details = async (req,res) => {
    const {user_id,id} = req.body;
    await Ropeway.scope(['active']).findOne({
        where:{
            id:id
        }
    }).then((rs)=>{
        return res.json(successRes('fetched',rs))
    })
}


const add_ropeway_enquiry = async (req, res) => {
    const {user_id,date,id,message,subject} = req.body;
    const dateTime =currentTimeStamp();
    await Enquiry.create({
        type:3,
        type_id:id,
        user_id,
        subject,
        message,
        date,
        created_at:dateTime
    }).then((rs)=>res.json(successRes('added!',rs)))
    .catch((err)=>res.json(failedRes('failed',err)))
}
module.exports = {
    fetch_ropeways,
    add_ropeway_enquiry,
    fetch_ropeway_details
};
