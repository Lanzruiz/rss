<?php
require __DIR__ . '/vendor/autoload.php';
// Requires: composer require firebase/php-jwt
use Firebase\JWT\JWT;

// Get your service account's email address and private key from the JSON key file
/*
$service_account_email = "firebase-adminsdk-uitag@firstwitness-97d7f.iam.gserviceaccount.com";
$private_key = "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCRj/60erh1LEWZ\nVkFRgSnxQakWk4nKyZ3Lyc81F167MYYRHs+QuUeHZbIU9Y06GSsu8XcEG9eCRYK5\nFVNVxBSYgtNZgOILTcNyYYqFQullMkaib81fvZZNGOJMUSJGjD46XEGrpLqCniPr\nOmb/Lt9SpZ6/m0t4AgxEeQV+Epx3BwnxQgXV1X5ulkz2WSGI4bZ2SL1n8fXp6ecu\nfJDc87XLMzWeZ6xY9pZLMYu3B24HqGLKNgZWToyCfWDKqEmc1khNjFryG/AycxDW\n4K9WYQ7VQilBWUSw3JRRKUaF0rlMnwwQX75DO6mZ7xP25JGmJZNYCiTVsQQ6TvnG\nEDmSXTUZAgMBAAECggEAQ3norGknEMoRCV++r7WcZ8X0SA7klSiZCVrnvsiylTwD\n1fPebEw3KECwKJ8bdI8uQXiVn0X4xN7MFlgYZW2bzob2ykrAflTyARfOSrAV2V9Q\n9wO0xGjyP5MFdDM4HFPulMcnehXGj74XEHfmPuzPgVRdHp0ygtMQNL2VGjguZ84c\nQV2TwdsQamtvEPnuTopok7paRLhWrhOPTOPzut5LPyhU9o2twpwO4GpR1CjyMt2y\n0w219LmF6WKxLXrneSnK4jyvpJPUgpS6Xv9pN0Iuhxn6CW0wm1gMTX1D6HJRr0Po\nMOkvi8CFUlhImxGaGWJK/be/4+toL2jGZOJE5HlG8QKBgQDMKAlJp8V5wFYvTu6i\nFsQzqbMdaFlJh+xDKJKYv7k6+sR+z1Xj7cPaGJzf4T/9npo4bzQsHdN+XFUA/k3a\nkKc2mNEwuDlGqVlHhRMQt29GeyQUfZyINKPsxEDDp6GSWbjuDvUhY+aCSZgD3Zu6\nr7ZxjQd1WdWTEJWK/1SfEViRxwKBgQC2htabOEkZBt2ln0ArLQLbS0u5STkNrDoh\nz8ELXtZ0f7WQW/k981KtIHhoB9fm0o6j07SOH/JjKm7vDIePACx5LzCmSeZ+4Gxt\nKykhclKBQSMGv23p4hw1k4BhYhD6cWtUVVVw+pEbsdbRpXNmqVgkHmCCsNl8dvAF\nmTCd/IACHwKBgQCpzLLM3AlW1i3YcyHvFlhhT8d1shBxI+fRg7FJ8kwxTdiYUAHz\n7RF0F/yCCGqcmolSXstZ1gTNmCXrCZffLWil9Dwo9VBOARQMdBYDVU3rpQfBMyg5\n8O5WQnRLRuUPQCibdz1SZDCYNHWG4Y5gmzx2/QEzDWChTK3UScEr+9VaiQKBgFUK\nQZaUBMqaPk5aAgWbtQcC78bl7KUIJxV1vBVWHEiu76LQlzFb2ps60550eQzb8QU3\nL5pAHChDrufFSKtBg3b6m4n+SFu4qAu83i7tGq+J743HRqh/ZnE3xcqZbBujGER0\ndZhrxYvHsbR/h2K/Z4d8d66sQsgQigextcsFx4Y1AoGALvtREKHBmSv89aOIFQi3\nbAfAoalzSPkWTzFx4uw8T2YuJvxEVf55Y7e40zGH9qQd/D/BPLkYJ3L3xTMnDLIh\n33tfx9OgYpz9NDbSteTpDWpdvJ8sxzJxvSfDSZ+Cf/rpcP0RRymOv8gfKEkeEk7X\nGtcsQ42guO4uZowdG0SZSGI=\n-----END PRIVATE KEY-----\n";
*/

#$service_account_email = "firebase-adminsdk-lse8j@smartglass-aed6d.iam.gserviceaccount.com";
#$private_key = "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDS9TuszsDZWarE\nc5Pjy4RrHnI2POxbMe2+N/8Bcr3af+p1R/hc2qRU9rYEKlaPtZ1yhFulbJG/dQB7\nAtbHdzqEHELW0ux10qfvCVJvlXXH6xKayM4SKefk9Cra9q8YtNyf5fKrndYDRwW1\nPzmwObQOi+CCZKWNm0n0ot3sNiQ0yEIixxt4R1PmRZDYFtH4OiL6GJmnX8dwkEZf\nXOKhyf0CeLtkJDbMp+Hfi50EtV7w4H5hafEH+zdt9WJ4nQG4fw3zpem4ltbvz5C+\n4xcovg47nuo/uirc5tHuALHtyIInowoGDaFd6PVZmaso1BC9qtVqGHyL0LQAEsdT\nMSe1aJlfAgMBAAECggEAM5BTtMqYosfjEL+7b1uok1JO0mkT0LqkhPFE+IKmW0kW\n8vHTiEa9EjN3jA8ZN2lKAdrOV+Hwwh6ELo0kGH9RI0eRItdNiwMhnzDlIHck4efY\nlVLt48ywbOstqnXPmLdkkgTvyvj6fbSXdZTtseB43XFdQCH/wVwquIwyuHEHaory\nbuJb2F1DEeHfMlLf7qSAmW3LDzbxZbvdmdxAQjqI6UeEpU8vO9IfhBUYyq5tP/hh\nEmR3lDdZKjHVd6WH9DPaCU3Tqk3ypZyTmrLouqKtSUmUm3FLhYsXfioHjOs8XMBA\nvYhNTEv/Ik2pKXmSwBQ3HuxOOXo1BU/pQc1M/qfKSQKBgQD9bdX7xSXQbkrD26Sx\ntIxUeyuwCzrk00T3/nnJyfPexu2oDPZi0ru9/12BolyCw4v5GIbbRCjwEuYIG+Wl\nENf49XqSEvvE1gk18hRV2IaQLuqvqkjTs7UX5RW4mMnfMzTOQCukEhnuu/I0a6Qx\nCFbS+tSjWLsuq725/S1sebQhKwKBgQDVGRkpHfJERwPH4pJGmDYrOALpHUlkXpiu\nUSHWLbjCO5mu81URmVfpKHwENxlWK3t3OZ3W9u4MM4XfpvbQHz3kHtIa1kYuJ4fp\n02ZL3DAkcdFth+iLIj+pXM9U0v4SnUrPyuqGqNBD9lH1OgTdhkO81cbHUfwF66Ar\ndv2Q4lvGnQKBgG4xY+mlP1vxmPCwgFwEdUAGjmhteZ4lfseWDr5+4VrshEmd2UP+\n/UMP1kiXoEH7ZNFaqMiOSn6YuQytlJzBRicqFbGOL4rWxgp+x/jLvTbUL5dSI3hp\nm0RYh6lMRfqW+U70+ATPGheEATxp0WrAhYAXMH4WBs20PzqvqyCPipMhAoGBAJmI\nVbpsGwraZ3zyXxWBwTVuS5qNQT2RckvVpJ1dn8pBir6kDtx5MP+J7aBT2mtdNL13\nw6MHkgc0b/Xto9HbUIo1MoenbjT+wkvTxdZONFltr8hMrVzhNiDd/3tL8UaUETyZ\nJFQU+Miehfo67Rp2DAPXujoNdZkGZQYr2xEyJZF5AoGAMejyxWV/gGbaHDOiYJ0R\ndxN2VEAi/UPti8orxYlUVY93MEFnPBPOJeLcwB+BVMlJ2QDR12nQ1V3xrOEPzuTB\nQWb4gZew6REHWYW2sEggfostA1SM2abeitIqDQNx32F7rt3U//+HbVhwFh5tcH5u\nzTcD/hHJqRk2J6LQqFPHHJo=\n-----END PRIVATE KEY-----\n";


$service_account_email = "firebase-adminsdk-fkysq@raptorsecuritysoftware-tk.iam.gserviceaccount.com";
$private_key = "-----BEGIN PRIVATE KEY-----\nMIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQDdRNDMpGZQrwZN\neOwX6AvBW5zPCS4fDJtNs4RJ1kCETsWdM6lgP+OHF5/3iCBtkekiLTRyFQ5DjiLI\njWGekmMxfrcDXA3COGfqPCUennAt6ELgoDeA3Ni4dCAaL+zy7WS+n6oAqyMEpUdC\nUsPVxl1ABvLXa+1VWDGk4mFYArAlK6tveUovYfqwUE3NUtE0cW/NGDkmKwkO1hbA\nGLK0fKIfAxzLaxtUxbSxbcHYklYhoi2/f/O2tKYg1yFqSBBAT8RgswaSLoZfE3Nh\nABMrl0t9+wRIYh+xDIxDwmJ9k49vNppUAWjSSac5F/a18kUx2e9/QBw8HoUKiWhe\n/2NQeObrAgMBAAECggEAadR7r51kCGwmLhDLj0WftbwtHIMOCbC8aSYW/D/a/M02\nTFGEzfHQz/DXRIvZwr5ajMulPXlfqKUHcvfYPIFUqzwpqZQySnYzEX/x2xq5meNw\ndUJ8OYinqVV1c0D/6lLr8Baqt4YjChpJImo2m300ZabNKIbI7ZxwpiXWnEMw352H\nRhDnrjCfzqN33+Wv7ncLpjs/qhpwRNs86P0E/ead5I77vWy9DPOx98v9f69RlwL6\nuxH3SiyrWBNrwW0FZclo3UMtW2PS7PTOcphR5S22T4h/pysqhfXQvWaBaea3MFPM\nfaqQGQcfDfz7PrtX7iWk4FAFqJeQC2qhCI0YI6eTvQKBgQDvEIl7nsz8CwClsE7E\nntjHm6vs1PGQ4TAaAbujPNx4ysw9d9CAS+H/t2DTDt3//DSlkwYfFz+FsLZnZU8/\nA+wJ22ItYC1q0ImCGl/B8+1fXmBltaLmQkbyFvYaSF2aheRFtwIA4HeGr1SQAF0r\nbv6Hs8ypBZCUukCjePIVHL7dpwKBgQDs8YzN0ytkC6une0NSFJ9hsm0nBQVkspAW\n2g770WrS/VnHqttQMtVZlWNTTWZD+MpS6Xa2PpJ+yBrpv7WGxCwbEOgTmOhWqM1Z\nlg14R8jdAAtEEqgU2wb/idjfgdQtEVDSM8XobHamx2ZPtYyNcHBRqp7L/v8QOfuU\nKQycFs89HQKBgQCycw2tEWTB3xSkmW6ypj/6/+Dd8DZBh1Z4k0KVHyETqY27dGxW\n2E3iq+fCpB5irsg9r/mpy5jHGpmNpLn6t9rBoNkwNdKxIOkEDNvd008lGTWrtmHa\nry52F12tUMdOSROUVn9QWD3gc5ATzbG+ciPc+AGVSWobGsyVOfq6d7KhkQKBgQCq\nfu2otYkFhnhQHZxFld1R+Ygdibllyi9wohwiC4DorbFKwaDqRonK2noMWSd7Rayg\nmKn5XXEglXD4PiCrBsIN/85fO6oDoZeSHS04Hb9ld0CkDSCxUSHqAxDxU4SPoWQc\nvXBtXI7MV7NBLAwlQoEv4qw9chGrZW2oIRmXv7oD6QKBgQCnGyPj5cXXuDfHD9f8\nhLzOdVrme8vUsLE5QO4Qxe4Q/bE7/AJVm9i/DWebvidKGbxgscjnZ04lqQfBEC4V\ntQRAb0WLXc91K0NrMFeTB/wWWdCZOYLI8rAqYDvKnEN6pzdpwSGfNOX0Ay28RxjH\nhzPX4dlZP/y1hsxQ175HrBX0mg==\n-----END PRIVATE KEY-----\n";

function create_custom_token($uid, $is_premium_account) {
  global $service_account_email, $private_key;

  $now_seconds = time();
  $payload = array(
    "iss" => $service_account_email,
    "sub" => $service_account_email,
    "aud" => "https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit",
    "iat" => $now_seconds,
    "exp" => $now_seconds+(60*60),  // Maximum expiration time is one hour
    "uid" => $uid,
    "claims" => array(
      "premium_account" => $is_premium_account
    )
  );
  return JWT::encode($payload, $private_key, "RS256");
}
$access_code = $_REQUEST['access_code'];
//$token =  create_custom_token("6938603895.0005898.e3b06d81e2734c1eabd431b21f508634","No");
$token = create_custom_token($access_code,"NO");
//echo "Access Token: ".$token.access_token;
$arr = array('token'=>$token);
echo json_encode($arr);
?>
