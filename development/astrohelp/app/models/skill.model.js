const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const Skill = sequelize.define("skills", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      user_id: {
        type: Sequelize.INTEGER,
      },
      speciality_id: {
        type: Sequelize.INTEGER,
      },
      status: {
        type: Sequelize.INTEGER,
      },
      experience: {
        type: Sequelize.INTEGER,
      },
      give_horoscope: {
        type: Sequelize.INTEGER,
      },
      horoscope_price: {
        type: Sequelize.FLOAT,
      },
      // created_at: {
      //   type: Sequelize.STRING
      // },
      // updated_at: {
      //   type: Sequelize.STRING
      // },
    },{
        timestamps: false,
        scopes:{
          active:{
            where:{status:1}
          },
        }
    });

    return Skill;
};