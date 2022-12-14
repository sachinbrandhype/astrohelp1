const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const Post = sequelize.define('notify_me',{
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      user_id: {
        type: Sequelize.STRING
      },
      astrologer_id: {
        type: Sequelize.TEXT
      },
      status: {
        type: Sequelize.INTEGER
      },
     
      created_at:  {
        type:  Sequelize.STRING,
      },

    },{
        tableName: 'notify_me',
        timestamps: false,
        scopes:{
          unnotified:{
            where:{status:0}
          },
          orderDesc:{
            order: [
              ['id','desc'],
            ]
          },
        }
    });

    return Post;
};
