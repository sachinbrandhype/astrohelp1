const dbConfig=require('../config/db.config');
const Sequelize=require('sequelize');
const sequelize=new Sequelize(dbConfig.DB,dbConfig.USER,dbConfig.PASSWORD, {
    host: dbConfig.HOST,
    dialect: dbConfig.dialect,
   // operatorsAliases: false,
    timezone: '+05:30', // for writing to database
    dialectOptions: {
        useUTC: false, //for reading from database
    },
   dialectOptions: {
    // useUTC: false, //for reading from database
    dateStrings: true,
    typeCast: function (field, next) { // for reading from database
      if (field.type === 'DATETIME') {
        return field.string()
      }
        return next()
      },
  },
    pool: {
      max: dbConfig.pool.max,
      min: dbConfig.pool.min,
      acquire: dbConfig.pool.acquire,
      idle: dbConfig.pool.idle
    }
});

sequelize
  .authenticate()
  .then(() => {
    console.log('Connection has been established successfully.');
  })
  .catch(err => {
    console.error('Unable to connect to the database:', err);
  });

const db = {};

db.Sequelize = Sequelize;
db.sequelize = sequelize;
db.User = require("./user.model.js")(sequelize, Sequelize);
db.Otpuser = require('./otpuser.model')(sequelize, Sequelize);
db.Banner = require('./banner.model')(sequelize, Sequelize);
db.Setting = require('./setting.model')(sequelize, Sequelize);
db.Puja = require('./puja.model')(sequelize, Sequelize);
db.Yoga = require('./yoga.model')(sequelize, Sequelize);
db.Yogavideo = require('./yogavideo.model')(sequelize, Sequelize);
db.Post = require('./post.model')(sequelize, Sequelize);
db.Horoscope = require('./horoscope.model')(sequelize, Sequelize);
db.City = require('./city.model')(sequelize, Sequelize);
db.Venue = require('./venue.model')(sequelize, Sequelize);
db.Pujavenue = require('./pujavenue.model')(sequelize, Sequelize);
db.Member = require('./member.model')(sequelize, Sequelize);
db.Cart = require('./cart.model')(sequelize, Sequelize);
db.Guest = require('./guest.model')(sequelize, Sequelize);
db.Astrologer = require('./astrologer.model')(sequelize, Sequelize);
db.Pujalocation = require('./pujalocation.model')(sequelize, Sequelize);
db.Pujatimeslot = require('./pujatimeslot.model')(sequelize, Sequelize);
db.Enquiry = require('./enquiry.model')(sequelize, Sequelize);
db.Booking = require('./booking.model')(sequelize, Sequelize);
db.Bookinghistory = require('./bookinghistory.model')(sequelize, Sequelize);
db.Transaction = require('./transaction.model')(sequelize, Sequelize);
db.Coupon = require('./coupon.model')(sequelize, Sequelize);
db.Couponapply = require('./couponapply.model')(sequelize, Sequelize);
db.Speciality = require('./speciality.model')(sequelize, Sequelize);
db.Skill = require('./skill.model')(sequelize, Sequelize);
db.Review = require('./review.model')(sequelize, Sequelize);
db.Kundalimatchuser = require('./kundalimatchuser.model')(sequelize, Sequelize);
db.Referralcodehistory = require('./referralcodehistory.model')(sequelize, Sequelize);
db.Ropeway = require('./ropeway.model')(sequelize, Sequelize);
db.Notification = require('./notification.model')(sequelize, Sequelize);
db.God = require('./god.model')(sequelize, Sequelize);
db.Temple = require('./temple.model')(sequelize, Sequelize);
db.Priest = require('./priest.model')(sequelize, Sequelize);
db.Supervisor = require('./supervisor.model')(sequelize, Sequelize);
db.Support = require('./support.model')(sequelize, Sequelize);
db.Ledgercode = require('./ledgercode.model')(sequelize, Sequelize);
db.DateWise = require('./datewise.model')(sequelize, Sequelize);
db.Bookingrequest = require('./bookingrequest.model')(sequelize, Sequelize);

db.Mastercancellation = require('./mastercancellation.model')(sequelize, Sequelize);
db.Notifyme = require('./notifyme.model')(sequelize, Sequelize);
db.Language = require('./language.model')(sequelize, Sequelize);

db.Broadcast = require('./broadcast.model')(sequelize, Sequelize);
db.Broadcastjoin = require('./broadcastjoin.model')(sequelize, Sequelize);


db.Follower = require('./follower.model')(sequelize, Sequelize);
db.Gift = require('./gift.model')(sequelize, Sequelize);

db.AstrologerNotification = require('./astrologernotification.model')(sequelize, Sequelize);
db.SendGift = require('./sendgift.model')(sequelize, Sequelize);

db.BookBroadcast = require('./bookbroadcast.model')(sequelize, Sequelize);

db.UserLogin = require('./userlogin.model')(sequelize, Sequelize);

db.CancellationReason = require('./cancellationreason.model')(sequelize, Sequelize);

db.AstrologerDiscount = require('./astrologerdiscount.model')(sequelize, Sequelize);

db.WalletPlan = require('./walletplan.model')(sequelize, Sequelize);

db.Cashfreetransaction = require('./cashfreetransaction.model')(sequelize, Sequelize);


module.exports = db;
