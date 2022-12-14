const { successRes, failedRes } = require("../helpers/response.helper");
const db = require("../models/index");
const Op=db.sequelize.Op;
const moment = require("moment");
const { checkIfAstrologerFav, currentTimeStamp, checkIfFav, averageRatingAstrologer, astrologerSpecialities } = require("../helpers/user.helper");
const { Favourite, Astrologer } = require("../models/index");


const toggle_favourite =async (req,res) => {
    const {user_id,astrologer_id} = req.body;
    const check = await checkIfAstrologerFav(astrologer_id,user_id);
    if(check){
        Favourite.destroy({
            where:{
                id:check.id
            }
        })
        return res.json(successRes('removed from favourites',check))

    }else{
        const storeData = {
            astrologer_id:astrologer_id,
            user_id:user_id,
            created_at:currentTimeStamp()
        }
        Favourite.create(storeData)
        return res.json(successRes('add to favourites',check))
    }
}

const fetch_favourite_astrologers = async (req,res) => {
    const {user_id} = req.body;
    var {limit,offset} = req.body;
    if (!offset) {
      offset = 0;
    }
    if (!limit) {
      limit = 10;
    }
  
    await Astrologer.belongsTo(Favourite, {foreignKey: 'id', targetKey: 'astrologer_id'})
    const ast = await Astrologer.findAll({
        limit:parseInt(limit),
        offset:parseInt(offset),
        include: [{
          model: Favourite,
          required: true
        }]
    }).then(async (astrologers) => {
        for (let astrologer of astrologers) {
          const rating = await averageRatingAstrologer(astrologer.id)
          const experties =await astrologerSpecialities(astrologer.id)
          const is_favourite = await  checkIfFav(astrologer.id,user_id)
          astrologer.dataValues.expertiesData=experties
          astrologer.dataValues.rating=rating
          astrologer.dataValues.is_favourite=is_favourite?1:0

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


module.exports = {
    toggle_favourite,
    fetch_favourite_astrologers
};
