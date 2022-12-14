const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const Post = sequelize.define('posts',{
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      name: {
        type: Sequelize.STRING
      },
      description: {
        type: Sequelize.TEXT
      },
      media: {
        type: Sequelize.STRING
      },
      thumbnail: {
        type: Sequelize.STRING
      },
      media_type: {
        type: Sequelize.INTEGER
      },
      status: {
        type: Sequelize.INTEGER
      },
      created_at:  {
        type: 'TIMESTAMP',
        defaultValue: Sequelize.literal('CURRENT_TIMESTAMP'),
      },
      updated_at: {
        type: 'TIMESTAMP',
      },
      thumbnailUrl: {
        type: DataTypes.VIRTUAL,
        get() {
          return `${imagePaths.post_video_thumbnail}${this.thumbnail}`;
        }
      },
      mediaUrl: {
          type: DataTypes.VIRTUAL,
          get() {
            return `${imagePaths.post_video}${this.media}`;
          }
      }
    },{
        tableName: 'posts',
        timestamps: false,
        scopes:{
          active:{
            where:{status:1}
          },
          video:{
            where:{media_type:3}
          },
          image:{
            where:{media_type:2}
          },

          orderAsc:{
            order: [
              ['created_at','asc'],
            ]
          },
          orderDesc:{
            order: [
              ['created_at','desc'],
            ]
          },
        }
    });

    return Post;
};
