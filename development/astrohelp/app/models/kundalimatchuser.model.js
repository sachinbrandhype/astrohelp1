const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const Kundalimatchuser = sequelize.define("kundalimatch_users", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      user_id: {
        type: Sequelize.INTEGER
      },
      name: {
        type: Sequelize.STRING
      },
      gender: {
        type: Sequelize.STRING
      },
      day: {
        type: Sequelize.INTEGER
      },
      month: {
        type: Sequelize.INTEGER
      },
      year: {
        type: Sequelize.INTEGER
      },
      hour: {
        type: Sequelize.INTEGER
      },
      min: {
        type: Sequelize.INTEGER
      },
      lat: {
        type: Sequelize.STRING
      },
      lon: {
        type: Sequelize.STRING
      },
      address: {
        type: Sequelize.STRING
      },
      tzone	: {
        type: Sequelize.STRING
      },
      created_at: {
        type: Sequelize.STRING
      },
      is_default:{
        type: Sequelize.INTEGER
      }
    },{
        timestamps: false,
        tableName: 'kundalimatch_users',
        scopes:{
          default:{
            where:{
              is_default:1
            }
          }
        }
    });

    return Kundalimatchuser;
};