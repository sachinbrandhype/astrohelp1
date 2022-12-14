const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const User = sequelize.define('user',{

      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      email: {
        type: Sequelize.STRING
      },
      password: {
        type: Sequelize.STRING
      },
      name: {
        type: Sequelize.STRING
      },
      father_name: {
        type: Sequelize.STRING
      },
      mother_name: {
        type: Sequelize.STRING
      },
      gotro: {
        type: Sequelize.STRING
      },
      spouse_name: {
        type: Sequelize.STRING
      },
      image: {
        type: Sequelize.STRING
      },
      dob: {
        type: Sequelize.STRING
      },
      birth_time: {
        type: Sequelize.STRING
      },
      place_of_birth: {
        type: Sequelize.STRING
      },
      gender: {
        type: Sequelize.STRING
      },
      language: {
        type: Sequelize.STRING
      },
      marital_status: {
        type: Sequelize.STRING
      },
      phone: {
        type: Sequelize.STRING
      },
      address : {
        type: Sequelize.TEXT
      },
      country: {
        type: Sequelize.STRING
      },
      state: {
        type: Sequelize.STRING
      },
      city: {
        type: Sequelize.STRING
      },
      zip: {
        type: Sequelize.STRING
      },
      latitude: {
        type: Sequelize.STRING
      },
      longitude: {
        type: Sequelize.STRING
      },
      auth: {
        type: Sequelize.STRING
      },
      email_verified_at: {
        type: Sequelize.STRING
      },
      phone_verified_at: {
        type: Sequelize.STRING
      },
      device_id: {
        type: Sequelize.STRING
      },
      device_type: {
        type: Sequelize.STRING
      },
      device_token : {
        type: Sequelize.TEXT
      },
      model_name: {
        type: Sequelize.STRING
      },
      loginTime: {
        type: Sequelize.STRING
      },
      referral_code: {
        type: Sequelize.STRING
      },
      wallet: {
        type: Sequelize.FLOAT
      },
      status: {
        type: Sequelize.INTEGER
      },
      created_at: {
        type: Sequelize.STRING
      },
      updated_at: {
        type: Sequelize.STRING
      },
      social_id: {
        type: Sequelize.STRING
      },
      imageUrl: {
          type: DataTypes.VIRTUAL,
          get() {
            return `${imagePaths.user}${this.image}`;
          }
      }
    },{
        tableName: 'user',
        timestamps: false,
        scopes:{
          active:{
            where:{status:1}
          },
        }
    });

    return User;
};
