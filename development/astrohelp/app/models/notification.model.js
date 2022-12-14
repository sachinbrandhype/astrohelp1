const { DataTypes } = require("sequelize");

module.exports = (sequelize, Sequelize) => {
    const Notification = sequelize.define("user_notification", {
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      user_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      booking_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      user_type: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      title: {
        type: DataTypes.STRING
      },
      image: {
        type: DataTypes.STRING
      },
      notification: {
        type: DataTypes.STRING
      },
      status: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      read: {
        type: DataTypes.INTEGER.UNSIGNED
      },

      added_on: {
        type: DataTypes.DATE
      }
    },{
        tableName:'user_notification',
        timestamps: false,
        scopes:{
          active:{
            where:{status:1}
          },
          user:{
            where:{user_type:1}
          },
          unread : {
              where:{
                  read:0
              }
          },
          newest:{
              order:[
                  ['id','desc']
              ]
          }
        }
    });

    return Notification;
};