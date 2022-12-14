const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

// const { DataTypes } = require("sequelize");
module.exports = (sequelize, Sequelize) => {
    const Review = sequelize.define("settings", {
        id: {
            primaryKey: true,
            type: Sequelize.INTEGER,
            autoIncrement: true,
        },
        explorehome_topbg:{
            type: Sequelize.STRING
        },
        ropeway_bg:{
            type: Sequelize.STRING
        },
        ropeway_txt:{
            type: Sequelize.STRING
        },
        astrologyhome_topbg:{
            type: Sequelize.STRING
        },
        about_us :{
            type: Sequelize.TEXT
        },
        terms_condition :{
            type: Sequelize.TEXT
        },
        privacy:{
            type: Sequelize.TEXT
        },
        helpline_number:{
            type: Sequelize.STRING
        },
        rechargeplans:{
            type: Sequelize.TEXT
        },
        gst_prct_for_wallet:{
            type: Sequelize.INTEGER
        },
        cashback_prct_for_wallet:{
            type: Sequelize.INTEGER
        },
        max_cashback_for_wallet:{
            type: Sequelize.INTEGER
        },

        explorehome_topbg_url: {
            type: DataTypes.VIRTUAL,
            get() {
                return `${imagePaths.setting}${this.explorehome_topbg}`;
            }
        },
        astrologyhome_topbg_url: {
            type: DataTypes.VIRTUAL,
            get() {
                return `${imagePaths.setting}${this.astrologyhome_topbg}`;
            }
        }
        ,
        ropeway_bg_url: {
            type: DataTypes.VIRTUAL,
            get() {
                return `${imagePaths.setting}${this.ropeway_bg}`;
            }
        }
    },{
        timestamps: false,
        // scopes:{
        //   active:{
        //     where:{status:1}
        //   },
        // }
    });

    return Review;
};