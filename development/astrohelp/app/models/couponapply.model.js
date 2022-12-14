module.exports = (sequelize, Sequelize) => {
    const Coupon = sequelize.define("coupon_applies", {
        id: {
            primaryKey: true,
            type: Sequelize.INTEGER,
            autoIncrement: true,
        },
        coupon_id:{
            type:Sequelize.INTEGER
        },
        user_id:{
            type:Sequelize.INTEGER
        },
        booking_id:{
            type:Sequelize.INTEGER
        },
        created_at:{
            type:'TIMESTAMP'
        },
    },{
        timestamps: false,
        tableName: 'coupon_applies',
        scopes:{
            orderDesc:{
                order: [
                    ['id','desc'],
                ]
            }
        }
    });

    return Coupon;
};