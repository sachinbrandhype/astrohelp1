const { DataTypes } = require("sequelize");
module.exports = (sequelize, Sequelize) => {
    const User = sequelize.define('user_logins',{

      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      user_id: {
        type: DataTypes.INTEGER
      },
      device_id: {
        type: DataTypes.STRING
      },
      device_type: {
        type: DataTypes.STRING
      },
      device_token: {
        type: DataTypes.STRING
      },
      model_name: {
        type: DataTypes.STRING
      },
      ip_address:{
        type: DataTypes.STRING
      },
      appversion:{
        type: DataTypes.STRING
      },
      is_login: {
        type: DataTypes.INTEGER
      },
      is_blocked: {
        type: DataTypes.INTEGER
      },

      created_at: {
        type: DataTypes.DATE
      },
      updated_at: {
        type: DataTypes.DATE
      },
    },{
        tableName: 'user_logins',
        timestamps: false,
        defaultScope:{},
        scopes:{
        }
    });

    return User;
};
