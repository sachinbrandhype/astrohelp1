const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const Cart = sequelize.define("carts", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      type: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      type_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      user_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      qty: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      city: {
        type: Sequelize.STRING
      },
      venue: {
        type: Sequelize.STRING
      },
      status: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      created_at: {
        type: Sequelize.INTEGER
      },
      host_type: {
        type: Sequelize.STRING
      },
      host_name: {
        type: Sequelize.STRING
      },
      host_dob: {
        type: Sequelize.STRING
      },
      host_tob: {
        type: Sequelize.STRING
      },
      host_pob: {
        type: Sequelize.STRING
      },
      host_mothername: {
        type: Sequelize.STRING
      },
      host_fathername: {
        type: Sequelize.STRING
      },
      host_gotro: {
        type: Sequelize.STRING
      },
      host_spouse: {
        type: Sequelize.STRING
      },
      guests: {
        type: Sequelize.STRING
      },
      schedule_date: {
        type: 'DATE'
      },
      schedule_time: {
        type: Sequelize.STRING
      },
      schedule_date_time: {
        type: Sequelize.STRING
      },
      added_by: {
        type: Sequelize.STRING
      },
      amount: {
        type: Sequelize.FLOAT
      },
      discount_price: {
        type: Sequelize.FLOAT
      },
      puja_id : {
        type: Sequelize.INTEGER.UNSIGNED
      },
      puja_location_id : {
        type: Sequelize.INTEGER.UNSIGNED
      },
      location_id : {
        type: Sequelize.INTEGER.UNSIGNED
      },
      host_id : {
        type: Sequelize.INTEGER.UNSIGNED
      }

    },{
        timestamps: false,
        tableName: 'carts',
        scopes:{
          // active:{
          //   where:{is_active:1}
          // },
        }
    });

    return Cart;
};