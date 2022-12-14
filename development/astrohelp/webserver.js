/**import packages */
process.env.TZ = 'Asia/Kolkata'
const express=require('express');
const bodyParser=require('body-parser');
const {  ValidationError  } = require('express-validation')
var redis = require('socket.io-redis');
const http = require('https')
const fs = require('fs')
// var multer = require('multer');
// var upload = multer();


const moment = require('moment');


const cors=require('cors');

/**intialize express server app */
const app=express();

// var server = http.createServer(app);

const httpsServer = http.createServer({
    // /etc/apache2/ssl/astrohelp24.key
    key: fs.readFileSync('/etc/apache2/ssl/astrohelp24.key'),
    cert: fs.readFileSync('/etc/apache2/ssl/astrohelp24.crt'),
    ca: [
        fs.readFileSync('/etc/apache2/ssl/addtrustexternalcaroot.cer'),
        fs.readFileSync('/etc/apache2/ssl/SectigoRSADomainValidationSecureServerCA.crt'),
        fs.readFileSync('/etc/apache2/ssl/astrohelp24bundle.crt')
    ]
}, app);


// SSLCertificateKeyFile /etc/apache2/ssl/astrohelp24.key
// SSLCertificateFile /etc/apache2/ssl/astrohelp24.crt
// SSLCertificateChainFile /etc/apache2/ssl/SectigoRSADomainValidationSecureServerCA.crt


var socket = require('socket.io');
var io = socket.listen(httpsServer);
io.adapter(redis({ host: 'localhost', port: 6379 }));
//console.log('CURRENT',moment().format('YYYY-MM-DD HH:mm:ss'));

app.use(cors());

/**create again table */
//db.sequelize.sync();
// db.sequelize.sync({ force: true }).then(() => {
//     //console.log("Drop and re-sync db.");
// });

/**parse requests as application/json */
app.use(express.json());

// parse requests of content-type - application/x-www-form-urlencoded
app.use(express.urlencoded({extended:true}));


/**validation error */
app.use(function(err, req, res, next) {

    if (err instanceof ValidationError) {
    return res.status(err.statusCode).json(err)
    // return res.json({status:false,message:err.message})

    }

    return res.status(500).json(err)
})


// process.on('unhandledRejection', function(e) {
//    //console.log(e);
//    process. exit();
// });


function postTrimmer(req, res, next) {
    if (req.method === 'POST') {
        for (const [key, value] of Object.entries(req.body)) {
            req.body[key] = Number.isNaN() ? value.trim() : value;
        }
    }
    next();
}

app.use(postTrimmer);


// simple route
app.get("/", (req, res) => {
    res.json({ 'headers' : req.headers,message: "Welcome to Astrohelp24 application new." });
});


app.use(function(req, res, next){
    res.io = io;
    // //console.log('io',io);
    next();
});
require("./app/socket/socket")(io);

require("./app/routes/main.routes")(app,io);



/**set port, listen requests */
const PORT=6030;
httpsServer.listen(PORT,()=>{
    console.log(`Server is running on port ${PORT}.`);
})
