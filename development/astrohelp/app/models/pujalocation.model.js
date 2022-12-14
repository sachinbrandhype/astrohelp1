const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const Puja = sequelize.define('pujalocation',{
        id: {
            primaryKey: true,
            type: Sequelize.INTEGER,
            autoIncrement: true,
        },
        puja_id: {
            type: Sequelize.INTEGER
        },
        location_id: {
            type: Sequelize.INTEGER
        },
        venue_id: {
            type: Sequelize.INTEGER
        },
        status: {
            type: Sequelize.INTEGER
        },
        gallery:{
            type:Sequelize.STRING
        },
        day_wise_time:{
            type:Sequelize.TEXT
        },
        day_wise_stock:{
            type:Sequelize.TEXT
        },
        any_time:{
            type:Sequelize.TEXT
        },
        created_at:{
            type:'TIMESTAMP'
        },
        galleryImgs: {
            type: DataTypes.VIRTUAL,
            get() {
                var gobj=[];
                if(this.gallery){
                    var gallery_imgs = this.gallery.split("|");
                    for (let gallery_img of gallery_imgs) {
                        const img = `${imagePaths.puja_gallery}${gallery_img}`;
                        gobj.push({img});
                    }
                }
                return gobj;
            }
        }
        // var gallery_imgs = await lc.gallery.split("|");
    },{
        tableName: 'puja_location_table',
        timestamps: false,
        scopes:{
            active:{
                where:{status:1}
            }
        }
    });

    return Puja;
};
