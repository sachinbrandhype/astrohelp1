const adminBaseUrl = 'https://astrohelp24.com/admin/';

module.exports = {
   customer_user:2,
   astrologer_user:3,
   jwtsecret: 'nodejsappastrohelp24appslurewebsolutionsllp',
   refreshJwtsecret: 'nodejsappastrohelp24appslurellpwebslution',
   jwtExpiration:86400*365*100,// expires in 24 hours,
   refreshJwtExpiration:(86400*60),
   adminBaseUrl:adminBaseUrl,
   imagePaths:{
      gift:adminBaseUrl+'uploads/gift/',

      banner:adminBaseUrl+'uploads/banner/user/',
      speciality:adminBaseUrl+'uploads/specialities/',
      horoscope:adminBaseUrl+'uploads/horoscope/',
      user:adminBaseUrl+'uploads/user/',
      astrologer:adminBaseUrl+'uploads/astrologers/',
      setting:adminBaseUrl+'uploads/settings/',
      puja:adminBaseUrl+'uploads/puja/',
      yoga:adminBaseUrl+'uploads/yoga/',
      puja_gallery:adminBaseUrl+'uploads/puja/',
      post_video:adminBaseUrl+'uploads/post/',
      post_video_thumbnail:adminBaseUrl+'uploads/post/',
      ropeway:adminBaseUrl+'uploads/ropeway/',
      priest:adminBaseUrl+'uploads/priest/',
      horoscope_matching:adminBaseUrl+'uploads/horoscope_matching/',

      bookingInvoice:adminBaseUrl+'uploads/invoices/',
      invoiceURL:adminBaseUrl+'Booking_management/invoice_genrate/',
      certificateURL:adminBaseUrl+'rollIAMfinal/complete-certificate.php?',
      poinvoiceUrl:adminBaseUrl+'Booking_management/pro_forma_invoice/',
      astrologerInvoice:adminBaseUrl+'Booking_management/astrologer_invoice_genrate/',
      cancel_invoice:adminBaseUrl+'Booking_management/cancellation_invoice/',
      cancel_invoice2:adminBaseUrl+'uploads/invoices/',
      share_puja:'http://139.59.25.187/pooja-details/'

   },
   aws:{
      aws_access_key_id :'AKIAWKL6GWKSULRK3RVW',
      aws_secret_access_key :'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',
   }
};