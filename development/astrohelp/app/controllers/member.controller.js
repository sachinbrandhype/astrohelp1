const { successRes, failedRes } = require("../helpers/response.helper");
const db = require("../models/index");
const { Member } = db;
const moment = require("moment");
const { Kundalimatchuser, User } = require("../models/index");
const { Op } = require('sequelize');
const { currentTimeStamp } = require("../helpers/user.helper");

const add_member = async (req,res) => {
    // const {name,dob,tob,pob,gender,language,message,location,mothername,fathername,gotro,spouse,user_id,type} = req.body;
    const {user_id,name,dob,tob,pob,mothername,fathername,gotro,spouse,gender}=req.body;
    const dateTime = await currentTimeStamp();;

    // if(!member){
    //     member={
    //         type:'host',
    //         name:user.name,
    //         dob:user.dob,
    //         tob:user.birth_time,
    //         pob:user.place_of_birth,
    //         mothername:user.mother_name,
    //         fathername:user.father_name,
    //         gotro:user.gotro,
    //         spouse:user.spouse_name,
    //         id:0,
    //     };
    // }

    const user = await User.findOne({
        where:{
            id:user_id
        }
    })
    if(user){
        // if(user.name=='Guest User'){ 

        //     User.update({
        //         name:name,
        //         dob:dob,
        //         gender:gender,
        //         birth_time:tob,
        //         place_of_birth:pob,
        //         mother_name:mothername,
        //         father_name:fathername,
        //         gotro:gotro,
        //         spouse_name:spouse
        //     },{
        //         where:{id:user_id}
        //     })
        // }
        User.update({
            name:name,
            dob:dob,
            gender:gender,
            birth_time:tob,
            place_of_birth:pob,
            mother_name:mothername,
            father_name:fathername,
            gotro:gotro,
            spouse_name:spouse
        },{
            where:{id:user_id}
        })
    }

    const storeData={...req.body,created_at:dateTime};
    await Member.update({
        status:2
    },{
        where:{
            user_id:user_id
        }
    })
    await Member.create(storeData).then((rs)=>res.json(successRes('added!!',rs))).catch((err)=>res.json(failedRes('something went wrong',err)));
}

const get_recently_added_member = async (req,res) => {
    const {user_id}=req.body;

    const member = await Member.scope(['active']).findOne({
        where:{
            user_id:user_id
        },
        order:[
            ['id','desc']
        ]
    })
    return res.json(successRes('success',member))
}

const delete_member = async (req,res) => {
    const {id,user_id}=req.body;

    await Member.destroy({
        where:{
            id:id,
            user_id,user_id
        }
    }).then((rs)=>res.json(successRes('deleted!!',rs)))
    .catch((err)=>res.json(failedRes('something went wrong.',err)))
}

const fetch_members = async (req,res)=>{
    const {user_id}=req.body;
    await Member.scope(['active']).findAll({
        where:{
            user_id:user_id
        }
    }).then((rs)=>res.json(successRes('fetched!!',rs)))
    .catch((err)=>res.json(failedRes('failed',err)))
}

const add_kundalimember = async (req,res) => {
    // const {user_id} = req.body;
    const dateTime =await currentTimeStamp();
    req.body.created_at=dateTime;
    req.body.is_default=1;
    await Kundalimatchuser.create(req.body).then(async (rs)=>{
        await Kundalimatchuser.update({
            is_default:0
        }, {
            where: { id: {
                [Op.ne]: id
            },user_id:user_id },
        })
    }).catch((err)=>res.json(failedRes('failed',err)))
}


const delete_kundalimember = async (req,res) => {
    const {id} = req.body;
    await Kundalimatchuser.destroy({
        where:{
            id:id
        }
    }).then((rs)=>res.json(successRes('deleted',rs))).catch((err)=>res.json(failedRes('failed',err)))
}

const set_default_kundali_member = async (req,res) => {
    const {id,user_id} = req.body;
    const update = await Kundalimatchuser.update({
        is_default:1
    }, {
        where: { id: id },
    })
    await Kundalimatchuser.update({
        is_default:0
    }, {
        where: { id: {
            [Op.ne]: id
        },user_id:user_id },
    })
    return res.json(successRes('done!',update))
}


const fetch_kundalimembers = async (req,res) => {
    const {user_id} = req.body;
    await Kundalimatchuser.findAll({
        where:{
            user_id:user_id
        }
    }).then((rs)=>res.json(successRes('deleted',rs))).catch((err)=>res.json(failedRes('failed',err)))
}
module.exports = {
    add_member,
    delete_member,
    fetch_members,
    add_kundalimember,
    delete_kundalimember,
    fetch_kundalimembers,
    set_default_kundali_member,
    get_recently_added_member
};
