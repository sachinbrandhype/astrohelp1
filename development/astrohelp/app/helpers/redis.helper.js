const redis = require('redis')
const {promisify} = require('util')


/**redis */

const client = redis.createClient({
    host:'redis-14656.c212.ap-south-1-1.ec2.cloud.redislabs.com',
    password:'UdUrDkOPJjq4zyi8u27CU1QApZxsNCnC',
    port:14656
})

const GET_REDIS_ASYNC = promisify(client.get).bind(client)
const SET_REDIS_ASYNC = promisify(client.set).bind(client)


module.exports = {
    GET_REDIS_ASYNC,
    SET_REDIS_ASYNC
}