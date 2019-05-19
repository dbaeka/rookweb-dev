define({ "api": [
  {
    "type": "post",
    "url": "/auth/check_user",
    "title": "Check User",
    "version": "0.0.1",
    "name": "CheckUser",
    "group": "Auth",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Checks if user exists with email or social account ID and then returns true if client can go ahead with registration ie. no user conflict. Returns false otherwise</p>",
    "parameter": {
      "fields": {
        "Social": [
          {
            "group": "Social",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User's email address</p>"
          },
          {
            "group": "Social",
            "type": "String",
            "allowedValues": [
              "\"facebook\"",
              "\"twitter\"",
              "\"linkedin\""
            ],
            "optional": false,
            "field": "socialType",
            "description": "<p>Social media type</p>"
          },
          {
            "group": "Social",
            "type": "String",
            "optional": false,
            "field": "socialID",
            "description": "<p>Unique ID of user with social account</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example (Email):",
          "content": "{\n    \"email\": \"kofirook@myrookery.com\",\n    \"socialType\": \"facebook\",\n    \"socialID\": \"Social ID\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "success",
            "defaultValue": "true",
            "description": "<p>Shows if request was successful or not</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorMessage",
            "description": "<p>Contains the error message generated</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorCode",
            "description": "<p>Programmable defined error messages</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result",
            "description": "<p>List of Request Output for User</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n     \"success\": true,\n     \"errorMessage\": null,\n     \"errorCode\": null,\n     \"result\": null\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "USER_EXIST",
            "description": "<p>User already exists and cannot create with email or social media account given</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "MISSING_PARAMETERS",
            "description": "<p>Missing one or two parameters in request</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response (Example):",
          "content": "HTTP/1.1 401 Not Authenticated\n{\n  \"success\": false,\n  \"errorMessage\": \"Missing some parameters in request\",\n  \"errorCode\": \"MISSING_PARAMETERS\",\n  \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./auth/check_user.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/auth/login",
    "title": "Login",
    "version": "0.0.1",
    "name": "LoginEmail",
    "group": "Auth",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Handles login via email address and password or via social account and returns an encrypted jwt to the client. The jwt contains the client apid used to request additional information anytime an api request outside the Auth group is made to the server</p>",
    "parameter": {
      "fields": {
        "Email": [
          {
            "group": "Email",
            "type": "String",
            "allowedValues": [
              "\"email\""
            ],
            "optional": false,
            "field": "type",
            "description": ""
          },
          {
            "group": "Email",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User's email address</p>"
          },
          {
            "group": "Email",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>User's password</p>"
          },
          {
            "group": "Email",
            "type": "String",
            "optional": false,
            "field": "firebaseToken",
            "description": "<p>Firebase token generated by client</p>"
          }
        ],
        "Social": [
          {
            "group": "Social",
            "type": "String",
            "allowedValues": [
              "\"social\""
            ],
            "optional": false,
            "field": "type",
            "description": ""
          },
          {
            "group": "Social",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>Social Media ID. e.g Facebook ID provided after authentication</p>"
          },
          {
            "group": "Social",
            "type": "String",
            "allowedValues": [
              "\"facebook\"",
              "\"twitter\"",
              "\"linkedin\""
            ],
            "optional": false,
            "field": "socialType",
            "description": "<p>Social Media Type</p>"
          },
          {
            "group": "Social",
            "type": "String",
            "optional": false,
            "field": "firebaseToken",
            "description": "<p>Firebase token generated by client</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example (Email):",
          "content": "{\n    \"type\": \"email\",\n    \"email\": \"kofirook@myrookery.com\",\n    \"password\": \"password\",\n    \"firebaseToken\": \"firebaseTokenHere\"\n}",
          "type": "json"
        },
        {
          "title": "Request-Example (Social):",
          "content": "{\n    \"type\": \"social\",\n    \"id\": \"Social Media ID here\",\n    \"socialType\": \"facebook\",\n    \"firebaseToken\": \"firebaseTokenHere\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "success",
            "defaultValue": "true",
            "description": "<p>Shows if request was successful or not</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorMessage",
            "description": "<p>Contains the error message generated</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorCode",
            "description": "<p>Programmable defined error messages</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result",
            "description": "<p>List of Request Output for User</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.jwt",
            "description": "<p>The JSON Web Token for the user</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result.user",
            "description": "<p>Contains list of user information</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.email",
            "description": "<p>Email address of user</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.firebaseToken",
            "description": "<p>Firebase Token returned to user</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n     \"success\": true,\n     \"errorMessage\": null,\n     \"errorCode\": null,\n     \"result\": {\n                 \"jwt\": \"generated JWT\",\n                 \"user\": {\n                             \"email\": \"kofirook@myrookery.com\",\n                             \"firebaseToken\": \"firebaseTokenHere\"\n                         }\n                }\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "USER_AUTHENTICATION_ERROR",
            "description": "<p>Invalid login details or user does not exist</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "INVALID_REQUEST",
            "description": "<p>Wrong request made to API endpoint</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "MISSING_PARAMETERS",
            "description": "<p>Missing one or two parameters in request</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response (Example):",
          "content": "HTTP/1.1 401 Not Authenticated\n{\n  \"success\": false,\n  \"errorMessage\": \"Missing some parameters in request\",\n  \"errorCode\": \"MISSING_PARAMETERS\",\n  \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./auth/login.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/auth/register",
    "title": "Register(Email)",
    "version": "0.0.1",
    "name": "RegisterEmail",
    "group": "Auth",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Handles registration via email address and password and requires usual sign up process and returns an encrypted jwt to the client. The jwt contains the client apid used to request additional information anytime an api request outside the Auth group is made to the server</p>",
    "parameter": {
      "fields": {
        "Email": [
          {
            "group": "Email",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User's email address</p>"
          },
          {
            "group": "Email",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>User's password</p>"
          },
          {
            "group": "Email",
            "type": "String",
            "optional": false,
            "field": "firebaseToken",
            "description": "<p>Firebase token generated by client</p>"
          },
          {
            "group": "Email",
            "type": "String",
            "optional": false,
            "field": "firstname",
            "description": "<p>User's firstname</p>"
          },
          {
            "group": "Email",
            "type": "String",
            "optional": false,
            "field": "lastname",
            "description": "<p>User's lastname</p>"
          },
          {
            "group": "Email",
            "type": "String",
            "allowedValues": [
              "\"m\"",
              "\"f\""
            ],
            "optional": false,
            "field": "gender",
            "description": "<p>User's gender</p>"
          },
          {
            "group": "Email",
            "type": "String",
            "optional": false,
            "field": "dateOfBirth",
            "description": "<p>User's date of birth. Format: dd MM yyyy eg. 20 February 1997</p>"
          },
          {
            "group": "Email",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>User's phone number. Format: 233NNNNNNNNN eg. 233501234567</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example (Email):",
          "content": "{\n    \"email\": \"kofirook@myrookery.com\",\n    \"password\": \"password\",\n    \"firebaseToken\": \"firebaseTokenHere\",\n    \"firstname\": \"Kofi\",\n    \"lastname\": \"Rook\",\n    \"gender\": \"m\",\n    \"dateOfBirth\": \"20 Februaru 1997\",\n    \"phone\": \"233501234567\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "success",
            "defaultValue": "true",
            "description": "<p>Shows if request was successful or not</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorMessage",
            "description": "<p>Contains the error message generated</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorCode",
            "description": "<p>Programmable defined error messages</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result",
            "description": "<p>List of Request Output for User</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.jwt",
            "description": "<p>The JSON Web Token for the user</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result.user",
            "description": "<p>Contains list of user information</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.email",
            "description": "<p>Email address of user</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.firebaseToken",
            "description": "<p>Firebase Token returned to user</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.firstname",
            "description": "<p>First name of user</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.lastname",
            "description": "<p>Last name of user</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n     \"success\": true,\n     \"errorMessage\": null,\n     \"errorCode\": null,\n     \"result\": {\n                 \"jwt\": \"generated JWT\",\n                 \"user\": {\n                             \"email\": \"kofirook@myrookery.com\",\n                             \"firstname\": \"Kofi\",\n                             \"lastname\": \"Rook\",\n                             \"firebaseToken\": \"firebaseTokenHere\"\n                         }\n                }\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "USER_CREATION_ERROR",
            "description": "<p>User exists or could not be created</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "MISSING_PARAMETERS",
            "description": "<p>Missing one or two parameters in request</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response (Example):",
          "content": "HTTP/1.1 401 Not Authenticated\n{\n  \"success\": false,\n  \"errorMessage\": \"Missing some parameters in request\",\n  \"errorCode\": \"MISSING_PARAMETERS\",\n  \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./auth/register.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/auth/social_register",
    "title": "Register(Social)",
    "version": "0.0.1",
    "name": "SocialEmail",
    "group": "Auth",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Handles registration via social media but requires using the check_user endpoint to first check if user exists with social account already. Returns an encrypted jwt to the client on success of creation. The jwt contains the client apid used to request additional information anytime an api request outside the Auth group is made to the server</p>",
    "parameter": {
      "fields": {
        "Social": [
          {
            "group": "Social",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User's email address</p>"
          },
          {
            "group": "Social",
            "type": "String",
            "optional": false,
            "field": "socialToken",
            "description": "<p>Social media auth token</p>"
          },
          {
            "group": "Social",
            "type": "String",
            "optional": false,
            "field": "firebaseToken",
            "description": "<p>Firebase token generated by client</p>"
          },
          {
            "group": "Social",
            "type": "String",
            "optional": false,
            "field": "firstname",
            "description": "<p>User's firstname</p>"
          },
          {
            "group": "Social",
            "type": "String",
            "optional": false,
            "field": "lastname",
            "description": "<p>User's lastname</p>"
          },
          {
            "group": "Social",
            "type": "String",
            "allowedValues": [
              "\"facebook\"",
              "\"twitter\"",
              "\"linkedin\""
            ],
            "optional": false,
            "field": "socialType",
            "description": "<p>Social media type</p>"
          },
          {
            "group": "Social",
            "type": "String",
            "optional": false,
            "field": "socialID",
            "description": "<p>Unique ID of user with social account</p>"
          },
          {
            "group": "Social",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>User's phone number. Format: 233NNNNNNNNN eg. 233501234567</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example (Email):",
          "content": " {\n     \"email\": \"kofirook@myrookery.com\",\n     \"socialToken\": \"Token here\",\n     \"firebaseToken\": \"firebaseTokenHere\",\n     \"firstname\": \"Kofi\",\n     \"lastname\": \"Rook\",\n     \"socialType\": \"facebook\",\n     \"socialID\": \"Social ID\",\n     \"phone\": \"233501234567\"\n }\n*",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "success",
            "defaultValue": "true",
            "description": "<p>Shows if request was successful or not</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorMessage",
            "description": "<p>Contains the error message generated</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorCode",
            "description": "<p>Programmable defined error messages</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result",
            "description": "<p>List of Request Output for User</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.jwt",
            "description": "<p>The JSON Web Token for the user</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result.user",
            "description": "<p>Contains list of user information</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.email",
            "description": "<p>Email address of user</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.firebaseToken",
            "description": "<p>Firebase Token returned to user</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.firstname",
            "description": "<p>First name of user</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.lastname",
            "description": "<p>Last name of user</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n     \"success\": true,\n     \"errorMessage\": null,\n     \"errorCode\": null,\n     \"result\": {\n                 \"jwt\": \"generated JWT\",\n                 \"user\": {\n                             \"email\": \"kofirook@myrookery.com\",\n                             \"firstname\": \"Kofi\",\n                             \"lastname\": \"Rook\",\n                             \"firebaseToken\": \"firebaseTokenHere\"\n                         }\n                }\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "USER_CREATION_ERROR",
            "description": "<p>User exists or could not be created</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "MISSING_PARAMETERS",
            "description": "<p>Missing one or two parameters in request</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response (Example):",
          "content": "HTTP/1.1 401 Not Authenticated\n{\n  \"success\": false,\n  \"errorMessage\": \"Missing some parameters in request\",\n  \"errorCode\": \"MISSING_PARAMETERS\",\n  \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./auth/social_register.php",
    "groupTitle": "Auth"
  },
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "varname1",
            "description": "<p>No type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p>"
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./apidoc/main.js",
    "group": "C__Users_dbaek_Documents_rookweb_dev_api_v0_apidoc_main_js",
    "groupTitle": "C__Users_dbaek_Documents_rookweb_dev_api_v0_apidoc_main_js",
    "name": ""
  },
  {
    "type": "get",
    "url": "/lists/companies",
    "title": "ListAllCompanies",
    "version": "0.0.1",
    "name": "ListAllCompanies",
    "group": "Lists",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Returns the companies on the platform and the short details to populate a list. Also contains if user is subscribed to the company</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-ROOK-token",
            "description": "<p>User's unique jwt sent from client</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "success",
            "defaultValue": "true",
            "description": "<p>Shows if request was successful or not</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorMessage",
            "description": "<p>Contains the error message generated</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorCode",
            "description": "<p>Programmable defined error messages</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result",
            "description": "<p>List of Request Output for User</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result.companies",
            "description": "<p>List of companies</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.companies.cname",
            "description": "<p>Company name</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.companies.type",
            "description": "<p>Company name</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.companies.location",
            "description": "<p>Company location address</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.companies.bio",
            "description": "<p>Company short bio</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.companies.logo",
            "description": "<p>Company logo url</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"1\"",
              "\"0\""
            ],
            "optional": false,
            "field": "result.companies.subscribed",
            "description": "<p>Company name</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "result.count",
            "description": "<p>Number of companies</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n     \"success\": true,\n     \"errorMessage\": null,\n     \"errorCode\": null,\n     \"result\": {\n                 \"count\": 1,\n                 \"companies\": [\n                            {\n                                 \"cname\": \"Rook+\",\n                                 \"type\": \"Tech\",\n                                 \"location\": \"East Legon, Accra Ghana\",\n                                 \"bio\": \"Company is a tech company specialized in recruitment\",\n                                 \"logo\": \"image URL\",\n                                 \"subscribed\": \"1\",\n                            }\n                         ]\n                }\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "JWT_INVALID",
            "description": "<p>Invalid jwt provided</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "JWT_EXPIRED",
            "description": "<p>jwt has expired and has been refreshed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response (Example):",
          "content": "HTTP/1.1 401 Not Authenticated\n{\n  \"success\": false,\n  \"errorMessage\": \"Access Denied\",\n  \"errorCode\": \"JWT_INVALID\",\n  \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./lists/companies.php",
    "groupTitle": "Lists"
  },
  {
    "type": "get",
    "url": "/lists/internships",
    "title": "ListAllInternships",
    "version": "0.0.1",
    "name": "ListAllInternships",
    "group": "Lists",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Returns the internships on the platform and the short details to populate a list. Also contains if user has applied</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-ROOK-token",
            "description": "<p>User's unique jwt sent from client</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "success",
            "defaultValue": "true",
            "description": "<p>Shows if request was successful or not</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorMessage",
            "description": "<p>Contains the error message generated</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorCode",
            "description": "<p>Programmable defined error messages</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result",
            "description": "<p>List of Request Output for User</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result.internships",
            "description": "<p>List of internships</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.cname",
            "description": "<p>Company name</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"free\"",
              "\"paid\""
            ],
            "optional": false,
            "field": "result.internships.type",
            "description": "<p>Type of internship</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.location",
            "description": "<p>Location of the internship</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.deadline",
            "description": "<p>Deadline for internship</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.logo",
            "description": "<p>Company logo url</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.id",
            "description": "<p>Internship id for getting specific internship from database</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.title",
            "description": "<p>Internhsip title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.category",
            "description": "<p>Category of company that posted</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"1\"",
              "\"0\""
            ],
            "optional": false,
            "field": "result.internships.is_applied",
            "description": "<p>True if student has applied for internship. False otherwise</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "result.count",
            "description": "<p>Number of internships</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\n{\n\"success\": true,\n\"errorMessage\": null,\n\"errorCode\": null,\n\"result\": {\n\"internships\": [\n{\n\"id\": \"2\",\n\"type\": \"free\",\n\"location\": \"East Legon\",\n\"title\": \"Graphic Designer\",\n\"deadline\": \"2020-04-23\",\n\"cname\": \"4 Byte Gh\",\n\"logo\": \"https://myrookery.com/img/avatar/rookCompa012dcd9e001b53.jpg\",\n\"category\": \"Design\",\n\"is_applied\": \"0\"\n},\n{\n\"id\": \"1\",\n\"type\": \"paid\",\n\"location\": \"Accra, Ghana\",\n\"title\": \"Software Engineer Intern\",\n\"deadline\": \"2020-06-16\",\n\"cname\": \"Rook+\",\n\"logo\": \"https://myrookery.com/img/avatar/companydfebe490a7.png\",\n\"category\": \"Technology\",\n\"is_applied\": \"0\"\n}\n],\n\"count\": 2\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "JWT_INVALID",
            "description": "<p>Invalid jwt provided</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "JWT_EXPIRED",
            "description": "<p>jwt has expired and has been refreshed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response (Example):",
          "content": "HTTP/1.1 401 Not Authenticated\n{\n  \"success\": false,\n  \"errorMessage\": \"Access Denied\",\n  \"errorCode\": \"JWT_INVALID\",\n  \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./lists/internships.php",
    "groupTitle": "Lists"
  },
  {
    "type": "get",
    "url": "/lists/recommended/internships",
    "title": "ListRecommendedInternships",
    "version": "0.0.1",
    "name": "ListRecommendedInternships",
    "group": "Lists_Recommendation",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Returns the recommended internships for a specific user based on profile on the platform and the short details to populate a list. Also contains if user has applied</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-ROOK-token",
            "description": "<p>User's unique jwt sent from client</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "success",
            "defaultValue": "true",
            "description": "<p>Shows if request was successful or not</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorMessage",
            "description": "<p>Contains the error message generated</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorCode",
            "description": "<p>Programmable defined error messages</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result",
            "description": "<p>List of Request Output for User</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result.internships",
            "description": "<p>List of internships</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.cname",
            "description": "<p>Company name</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"free\"",
              "\"paid\""
            ],
            "optional": false,
            "field": "result.internships.type",
            "description": "<p>Type of internship</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.location",
            "description": "<p>Location of the internship</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "allowedValues": [
              "\"1-4\""
            ],
            "optional": false,
            "field": "result.internships.priority",
            "description": "<p>Priority number indicates the level of best match. 4 being highest</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.deadline",
            "description": "<p>Deadline for internship</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.logo",
            "description": "<p>Company logo url</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.id",
            "description": "<p>Internship id for getting specific internship from database</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.title",
            "description": "<p>Internhsip title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.internships.category",
            "description": "<p>Category of company that posted</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"1\"",
              "\"0\""
            ],
            "optional": false,
            "field": "result.internships.is_applied",
            "description": "<p>True if student has applied for internship. False otherwise</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "result.count",
            "description": "<p>Number of internships</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\n{\n\"success\": true,\n\"errorMessage\": null,\n\"errorCode\": null,\n\"result\": {\n\"internships\": [\n{\n\"id\": \"2\",\n\"type\": \"free\",\n\"location\": \"East Legon\",\n\"title\": \"Graphic Designer\",\n\"deadline\": \"2020-04-23\",\n\"cname\": \"4 Byte Gh\",\n\"logo\": \"https://myrookery.com/img/avatar/rookCompa012dcd9e001b53.jpg\",\n\"category\": \"Design\",\n\"is_applied\": \"0\",\n\"priority\": 3\n},\n{\n\"id\": \"1\",\n\"type\": \"paid\",\n\"location\": \"Accra, Ghana\",\n\"title\": \"Software Engineer Intern\",\n\"deadline\": \"2020-06-16\",\n\"cname\": \"Rook+\",\n\"logo\": \"https://myrookery.com/img/avatar/companydfebe490a7.png\",\n\"category\": \"Technology\",\n\"is_applied\": \"0\",\n\"priority\": 2\n}\n],\n\"count\": 2\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "JWT_INVALID",
            "description": "<p>Invalid jwt provided</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "JWT_EXPIRED",
            "description": "<p>jwt has expired and has been refreshed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response (Example):",
          "content": "HTTP/1.1 401 Not Authenticated\n{\n  \"success\": false,\n  \"errorMessage\": \"Access Denied\",\n  \"errorCode\": \"JWT_INVALID\",\n  \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./lists/recommended/internships.php",
    "groupTitle": "Lists_Recommendation"
  },
  {
    "type": "get",
    "url": "/users/profile",
    "title": "GetUserProfile",
    "version": "0.0.1",
    "name": "GetUserProfile",
    "group": "Users",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Returns the student's complete profile</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-ROOK-token",
            "description": "<p>User's unique jwt sent from client</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "success",
            "defaultValue": "true",
            "description": "<p>Shows if request was successful or not</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorMessage",
            "description": "<p>Contains the error message generated</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorCode",
            "description": "<p>Programmable defined error messages</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "result",
            "description": "<p>List of Request Output for User</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "result.user",
            "description": "<p>User info for student</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.fname",
            "description": "<p>Student first name</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.lnzme",
            "description": "<p>Student last name</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"m\"",
              "\"f\""
            ],
            "optional": false,
            "field": "result.user.gender",
            "description": "<p>Student gender</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.dob",
            "description": "<p>Student date of birth. Format: year-month-day eg. 1997-02-20</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.city",
            "description": "<p>City student is located in</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.nationality",
            "description": "<p>Student nationality</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"employed\"",
              "\"student\""
            ],
            "optional": false,
            "field": "result.user.employment_status",
            "description": "<p>Student employment status</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"single\"",
              "\"married\""
            ],
            "optional": false,
            "field": "result.user.marital_status",
            "description": "<p>Student marital status</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.phone",
            "description": "<p>Student phone number</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.avatar",
            "description": "<p>Student avatar url</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.email",
            "description": "<p>Student email address</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result.user.interests",
            "description": "<p>List of student's interests</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.interests.title",
            "description": "<p>Title of student's interest</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.interests.id",
            "description": "<p>id of student's interest as saved in database</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result.user.education",
            "description": "<p>List of student's education</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.education.name",
            "description": "<p>Name of student's school</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.education.id",
            "description": "<p>id of student's education as in database</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.education.completion",
            "description": "<p>Year of completion from school</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.education.course",
            "description": "<p>Course taken in school</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.education.level",
            "description": "<p>Level of student in the school</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "result.user.stats",
            "description": "<p>Student's statistics information</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "result.user.stats.total_tasks",
            "description": "<p>Total tasks started by student</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "result.user.stats.completed",
            "description": "<p>Number of completed tasks</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "result.user.stats.points",
            "description": "<p>Points accrued by student</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "result.user.stats.success_rate",
            "description": "<p>Success rate of student</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "result.user.stats.speed",
            "description": "<p>Speed score of student</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result.user.stats.badges",
            "description": "<p>List of student's badge achievements</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.stats.badges.name",
            "description": "<p>Name of student's badge</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.stats.badges.image",
            "description": "<p>Image url for badge achieved</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result.user.experience",
            "description": "<p>List of student's work experience</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.experience.name",
            "description": "<p>Name of student's workplace</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.experience.id",
            "description": "<p>id of student's work experience as in database</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.experience.location",
            "description": "<p>Location of workplace</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.experience.title",
            "description": "<p>Title of experience or position</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"1\"",
              "\"0\""
            ],
            "optional": false,
            "field": "result.user.experience.is_current",
            "description": "<p>If student is cuurently at the workplace</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.experience.start_date",
            "description": "<p>Start date of experience. Format: year-month eg. 2012-01</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.experience.end_date",
            "description": "<p>End date of experience. Format: year-month eg. 2012-01</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result.user.skills",
            "description": "<p>List of student's skills</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.skills.title",
            "description": "<p>Title of student's skills</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.skills.id",
            "description": "<p>id of student's skill as saved in database</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result.user.portfolio",
            "description": "<p>List of student's portfolio</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.portfolio.name",
            "description": "<p>Name of student's portfolio</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.portfolio.id",
            "description": "<p>id of student's portfolio as in database</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.portfolio.description",
            "description": "<p>Portfolio description</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.portfolio.start_date",
            "description": "<p>Start date of experience. Format: year-month eg. 2012-01</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.portfolio.end_date",
            "description": "<p>End date of experience. Format: year-month eg. 2012-01</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result.user.portfolio.items",
            "description": "<p>List of links or images added to portfolio</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.portfolio.items.item_id",
            "description": "<p>id of item in database</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"link\"",
              "\"image\""
            ],
            "optional": false,
            "field": "result.user.portfolio.items.type",
            "description": "<p>Type of portfolio item</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.user.portfolio.items.url",
            "description": "<p>Url of portfolio item</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "result.user.aptitude",
            "description": "<p>Student aptitude tests information</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "result.user.aptitude.tests_taken",
            "description": "<p>Number of tests taken</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "result.user.aptitude.highest_score",
            "description": "<p>Highest score on all tests taken</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "result.user.aptitude.average_score",
            "description": "<p>Average score on all tests taken</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "result.user.aptitude.percentile",
            "description": "<p>Percentile of compared to other test takers</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n\"success\": true,\n\"errorMessage\": null,\n\"errorCode\": null,\n\"result\": {\n\"user\": {\n\"fname\": \"Delmwin\",\n\"lname\": \"Baea\",\n\"gender\": \"m\",\n\"dob\": \"1997-02-13\",\n\"city\": \"Accra\",\n\"nationality\": \"Ghana\",\n\"employment_status\": \"student\",\n\"marital_status\": \"single\",\n\"phone\": \"233503878809\",\n\"avatar\": \"https://myrookery.com/img/avatar/rookUser465.png\",\n\"email\": \"delmwinbaeka@myrookery.com\",\n\"interests\": [\n{\n\"title\": \"dancing\",\n\"id\": \"3\"\n},\n{\n\"title\": \"surfing\",\n\"id\": \"4\"\n}\n],\n\"education\": [\n{\n\"name\": \"University of Ghana\",\n\"id\": \"18\",\n\"completion\": \"2025\",\n\"course\": \"Electrical Engineering\",\n\"level\": \"Sophomore\"\n},\n{\n\"name\": \"University of Michigan\",\n\"id\": \"19\",\n\"completion\": \"2020\",\n\"course\": \"Electrical Engineering\",\n\"level\": \"Sophomore\"\n}\n],\n\"stats\": {\n\"total_tasks\": 20,\n\"completed\": 4,\n\"points\": 689,\n\"success_rate\": 20,\n\"speed\": 60,\n\"badges\": [\n{\n\"name\": \"badge1\",\n\"image\": \"https://badges/1\"\n},\n{\n\"name\": \"badge2\",\n\"image\": \"https://badges/2\"\n}\n]\n},\n\"experience\": [\n{\n\"name\": \"Rook+\",\n\"id\": \"25\",\n\"location\": \"Tema, Ghana\",\n\"title\": \"Electrical Engineer\",\n\"is_current\": \"0\",\n\"start_date\": \"2018-03\",\n\"end_date\": \"2019-02\"\n},\n{\n\"name\": \"DreamOval Limited\",\n\"id\": \"26\",\n\"location\": \"Accra, Ghana\",\n\"title\": \"Software Engineer Intern\",\n\"is_current\": \"0\",\n\"start_date\": \"0\",\n\"end_date\": \"0\"\n}\n],\n\"skills\": [\n{\n\"title\": \"c++\",\n\"id\": \"1\"\n},\n{\n\"title\": \"python\",\n\"id\": \"2\"\n}\n],\n\"portfolio\": [\n{\n\"title\": \"iOS App Project\",\n\"id\": \"1\",\n\"description\": \"Project about developing iOS apps for everyone\",\n\"start_date\": \"2019-02\",\n\"end_date\": \"2020-05\",\n\"items\": null\n},\n{\n\"title\": \"iOS App Project 2\",\n\"id\": \"2\",\n\"description\": \"Project about developing iOS apps for everyone\",\n\"start_date\": \"2019-02\",\n\"end_date\": \"2020-05\",\n\"items\": null\n},\n{\n\"title\": \"iOS App Project\",\n\"id\": \"19\",\n\"description\": \"Project about developing iOS apps for everyone\",\n\"start_date\": \"2019-02\",\n\"end_date\": \"2020-05\",\n\"items\": null\n},\n{\n\"title\": \"iOS App Project 2\",\n\"id\": \"20\",\n\"description\": \"Project about developing iOS apps for everyone\",\n\"start_date\": \"2019-02\",\n\"end_date\": \"2020-05\",\n\"items\": [\n{\n\"item_id\": \"22\",\n\"type\": \"image\",\n\"url\": \"https://winiw.eqeoqco.qefqfqef\"\n},\n{\n\"item_id\": \"24\",\n\"type\": \"link\",\n\"url\": \"https://sdwrfwr.eqeoqco.qefqfqef\"\n},\n{\n\"item_id\": \"23\",\n\"type\": \"image\",\n\"url\": \"https://adadadao.qefqfqef\"\n}\n]\n}\n],\n\"aptitude\": {\n\"tests_taken\": 20,\n\"highest_score\": 69,\n\"average_score\": 99,\n\"percentile\": 64\n}\n}\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "JWT_INVALID",
            "description": "<p>Invalid jwt provided</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "JWT_EXPIRED",
            "description": "<p>jwt has expired and has been refreshed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response (Example):",
          "content": "HTTP/1.1 401 Not Authenticated\n{\n  \"success\": false,\n  \"errorMessage\": \"Access Denied\",\n  \"errorCode\": \"JWT_INVALID\",\n  \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./users/profile.php",
    "groupTitle": "Users"
  },
  {
    "type": "post",
    "url": "/users/update_demographics",
    "title": "UpdateUserDemographics",
    "version": "0.0.1",
    "name": "UpdateUserDemographics",
    "group": "Users",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Update the demographic information of student. Returns true if successful. False otherwise</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-ROOK-token",
            "description": "<p>User's unique jwt sent from client</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "fname",
            "description": "<p>Student first name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "lnzme",
            "description": "<p>Student last name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"m\"",
              "\"f\""
            ],
            "optional": true,
            "field": "gender",
            "description": "<p>Student gender</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "dob",
            "description": "<p>Student date of birth. Format: day month year eg. 20 February 1997</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "city",
            "description": "<p>City student is located in</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "nationality",
            "description": "<p>Student nationality. List of available countries is populated from lists/countries endpoint</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"employed\"",
              "\"student\""
            ],
            "optional": true,
            "field": "employment_status",
            "description": "<p>Student employment status</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"single\"",
              "\"married\""
            ],
            "optional": true,
            "field": "marital_status",
            "description": "<p>Student marital status</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "phone",
            "description": "<p>Student phone number</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "avatar",
            "description": "<p>Student avatar url</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "email",
            "description": "<p>Student email address</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n\"fname\": \"Delmwin\",\n\"lname\": \"Baea\",\n\"city\": \"Accra\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "success",
            "defaultValue": "true",
            "description": "<p>Shows if request was successful or not</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorMessage",
            "description": "<p>Contains the error message generated</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorCode",
            "description": "<p>Programmable defined error messages</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result",
            "description": "<p>List of Request Output for User</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n     \"success\": true,\n     \"errorMessage\": null,\n     \"errorCode\": null,\n     \"result\": null\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "UPDATE_EDUCATION_ERROR",
            "description": "<p>Education already exists for user</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "MISSING_PARAMETERS",
            "description": "<p>Missing one or two parameters in request</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response (Example):",
          "content": "HTTP/1.1 401 Not Authenticated\n{\n  \"success\": false,\n  \"errorMessage\": \"Education already exists for user\",\n  \"errorCode\": \"UPDATE_EDUCATION_ERROR\",\n  \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./users/update_demographics.php",
    "groupTitle": "Users"
  },
  {
    "type": "post",
    "url": "/users/update_education",
    "title": "UpdateUserEducation",
    "version": "0.0.1",
    "name": "UpdateUserEducation",
    "group": "Users",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Adds the array of education to the specified user. Returns true if at least one new education was added. Returns false otherwise.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-ROOK-token",
            "description": "<p>User's unique jwt sent from client</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "education",
            "description": "<p>List of education</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "education.school_id",
            "description": "<p>School ID of schools in database. The list of schools is retrieved from database using lists/schools endpoint. Use value of -1 for schools not found in the list (Requires you use name and location)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "education.name",
            "description": "<p>Name of school if not in the list. Use if school_id is -1</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "education.location",
            "description": "<p>Location of added school that is not in the list. Use if school_id is -1</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "education.id",
            "description": "<p>id of education if the user is updating an old education. Omit if the education is a new addition</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "education.course",
            "description": "<p>Course student is offering</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "education.completion",
            "description": "<p>Completion year of education. Format: year eg. 2019</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "education.level",
            "description": "<p>Level of student. Eg. Sophomore, SHS3 etc</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "count",
            "description": "<p>Number of education in list</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "\n {\n\"education\": [\n{\n\"school_id\": 1,\n\"id\": 18,\n\"course\": \"Electrical Engineering\",\n\"completion\": 2025,\n\"level\": \"Sophomore\"\n},\n{\n\"school_id\": -1,\n\"name\": \"University of Michigan\",\n\"location\": \"Michigan, Detroit\",\n\"course\": \"Electrical Engineering\",\n\"completion\": 2020,\n\"level\": \"Sophomore\"\n}\n],\n\"count\": 2\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "success",
            "defaultValue": "true",
            "description": "<p>Shows if request was successful or not</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorMessage",
            "description": "<p>Contains the error message generated</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorCode",
            "description": "<p>Programmable defined error messages</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result",
            "description": "<p>List of Request Output for User</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n     \"success\": true,\n     \"errorMessage\": null,\n     \"errorCode\": null,\n     \"result\": null\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "UPDATE_EDUCATION_ERROR",
            "description": "<p>Education already exists for user</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "MISSING_PARAMETERS",
            "description": "<p>Missing one or two parameters in request</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response (Example):",
          "content": "HTTP/1.1 401 Not Authenticated\n{\n  \"success\": false,\n  \"errorMessage\": \"Education already exists for user\",\n  \"errorCode\": \"UPDATE_EDUCATION_ERROR\",\n  \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./users/update_education.php",
    "groupTitle": "Users"
  },
  {
    "type": "post",
    "url": "/users/update_interests",
    "title": "UpdateUserInterests",
    "version": "0.0.1",
    "name": "UpdateUserInterests",
    "group": "Users",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Adds the array of interests to the specified user. Returns true if at least one new interest was added. Returns false otherwise.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-ROOK-token",
            "description": "<p>User's unique jwt sent from client</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "interests",
            "description": "<p>List of interests</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "interests.title",
            "description": "<p>Title of interest</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "count",
            "description": "<p>Number of interests in list</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": " {\n    \"interests\": [\n        {\n            \"title\": \"dancing\"\n        },\n        {\n            \"title\": \"surfing\"\n        }\n   ],\n    \"count\": 2\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "success",
            "defaultValue": "true",
            "description": "<p>Shows if request was successful or not</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorMessage",
            "description": "<p>Contains the error message generated</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorCode",
            "description": "<p>Programmable defined error messages</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result",
            "description": "<p>List of Request Output for User</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n     \"success\": true,\n     \"errorMessage\": null,\n     \"errorCode\": null,\n     \"result\": null\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "UPDATE_INTERESTS_ERROR",
            "description": "<p>Interest already exists for user in database</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "MISSING_PARAMETERS",
            "description": "<p>Missing one or two parameters in request</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response (Example):",
          "content": "HTTP/1.1 401 Not Authenticated\n{\n  \"success\": false,\n  \"errorMessage\": \"Interest already exists for user\",\n  \"errorCode\": \"UPDATE_INTERESTS_ERROR\",\n  \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./users/update_interests.php",
    "groupTitle": "Users"
  },
  {
    "type": "post",
    "url": "/users/update_portfolio",
    "title": "UpdateUserPortfolio",
    "version": "0.0.1",
    "name": "UpdateUserPortfolio",
    "group": "Users",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Adds the array of portfolio to the specified user. Returns true if at least one new portfolio was added. Returns false otherwise.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-ROOK-token",
            "description": "<p>User's unique jwt sent from client</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "portfolio",
            "description": "<p>List of portfolio</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "portfolio.title",
            "description": "<p>Title of portoflio</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "portfolio.id",
            "description": "<p>id of portoflio if the user is updating an old portfolio. Omit if the portfolio is a new addition</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "portfolio.description",
            "description": "<p>Description of portoflio</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "portfolio.start_date",
            "description": "<p>Start date of portoflio. Format: month year eg. March 2019</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "portfolio.end_date",
            "description": "<p>End date of portoflio. Format: month year eg. March 2019</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": true,
            "field": "portfolio.items",
            "description": "<p>Items represents images or links added to the portfolio</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"link\"",
              "\"image\""
            ],
            "optional": false,
            "field": "portfolio.items.type",
            "description": "<p>Type of portoflio item</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "portfolio.items.url",
            "description": "<p>Url of image to add, or link</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "portfolio.items.item_id",
            "description": "<p>id of portoflio item if the user is updating an old portfolio item. Omit if the portfolio item is a new addition</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "count",
            "description": "<p>Number of portfolio in list</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n     \"portfolio\": [\n         {\n             \"title\": \"iOS App Project\",\n             \"description\": \"Project about developing iOS apps for everyone\",\n             \"start_date\": \"February 2019\",\n             \"end_date\": \"May 2020\"\n         },\n         {\n             \"title\": \"iOS App Project 2\",\n             \"id\": 12,\n             \"description\": \"Project about developing iOS apps for everyone\",\n             \"start_date\": \"February 2019\",\n             \"end_date\": \"May 2020\",\n             \"items\": [\n                 {\n                     \"type\": \"image\",\n                     \"url\": \"https://winiw.eqeoqco.qefqfqef\"\n                 },\n                 {\n                     \"type\": \"image\",\n                     \"url\": \"https://adadadao.qefqfqef\"\n                 },\n                 {\n                     \"type\": \"link\",\n                     \"url\": \"https://sdwrfwr.eqeoqco.qefqfqef\"\n                 }\n             ]\n         }\n     ],\n     \"count\": 2\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "success",
            "defaultValue": "true",
            "description": "<p>Shows if request was successful or not</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorMessage",
            "description": "<p>Contains the error message generated</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorCode",
            "description": "<p>Programmable defined error messages</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result",
            "description": "<p>List of Request Output for User</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n     \"success\": true,\n     \"errorMessage\": null,\n     \"errorCode\": null,\n     \"result\": null\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "UPDATE_PORTFOLIO_ERROR",
            "description": "<p>Portfolio could not be added for user</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "MISSING_PARAMETERS",
            "description": "<p>Missing one or two parameters in request</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response (Example):",
          "content": "HTTP/1.1 401 Not Authenticated\n{\n  \"success\": false,\n  \"errorMessage\": \"Portfolio could not be added for user\",\n  \"errorCode\": \"UPDATE_PORTFOLIO_ERROR\",\n  \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./users/update_portfolio.php",
    "groupTitle": "Users"
  },
  {
    "type": "post",
    "url": "/users/update_skills",
    "title": "UpdateUserSkills",
    "version": "0.0.1",
    "name": "UpdateUserSkills",
    "group": "Users",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Adds the array of skills to the specified user. Returns true if at least one new skill was added. Returns false otherwise.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-ROOK-token",
            "description": "<p>User's unique jwt sent from client</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "skills",
            "description": "<p>List of skills</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "skills.title",
            "description": "<p>Title of skill</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "count",
            "description": "<p>Number of skills in list</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": " {\n    \"skills\": [\n        {\n            \"title\": \"C++\"\n        },\n        {\n            \"title\": \"Python\"\n        }\n   ],\n    \"count\": 2\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "success",
            "defaultValue": "true",
            "description": "<p>Shows if request was successful or not</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorMessage",
            "description": "<p>Contains the error message generated</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "errorCode",
            "description": "<p>Programmable defined error messages</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "result",
            "description": "<p>List of Request Output for User</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n     \"success\": true,\n     \"errorMessage\": null,\n     \"errorCode\": null,\n     \"result\": null\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "UPDATE_SKILLS_ERROR",
            "description": "<p>Skill already exists for user</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "MISSING_PARAMETERS",
            "description": "<p>Missing one or two parameters in request</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response (Example):",
          "content": "HTTP/1.1 401 Not Authenticated\n{\n  \"success\": false,\n  \"errorMessage\": \"Skill already exists for user\",\n  \"errorCode\": \"UPDATE_SKILLS_ERROR\",\n  \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./users/update_skills.php",
    "groupTitle": "Users"
  },
  {
    "type": "post",
    "url": "/users/update_work_xp",
    "title": "UpdateUserWorkExperience",
    "version": "0.0.1",
    "name": "UpdateUserWorkExperience",
    "group": "Users",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Adds the array of work experience to the specified user. Returns true if at least one new work experience was added. Returns false otherwise.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-ROOK-token",
            "description": "<p>User's unique jwt sent from client</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "work_experience",
            "description": "<p>List of work experience</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "work_experience.workplace_id",
            "description": "<p>Workplace ID of workplace in database. The list of workplaces is retrieved from database using lists/workplaces endpoint. Use value of -1 for workplace not found in the list (Requires you use name and location)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "work_experience.name",
            "description": "<p>Name of workplace if not in the list. Use if workplace_id is -1</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "work_experience.location",
            "description": "<p>Location of added workplace that is not in the list. Use if workplace_id is -1</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "work_experience.id",
            "description": "<p>id of work experience if the user is updating an old work experience. Omit if the work experience is a new addition</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "work_experience.title",
            "description": "<p>Title of work experience</p>"
          },
          {
            "group": "Parameter",
            "type": "Bool",
            "optional": false,
            "field": "work_experience.is_current",
            "description": "<p>True if student still works here. False otherwise</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "work_experience.start_date",
            "description": "<p>Start date of work experience. Format: month year eg. March 2019</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "work_experience.end_date",
            "description": "<p>End date of work experience. Format: month year eg. March 2019</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "count",
            "description": "<p>Number of work experience in list</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "\n {\n\"work_experience\": [\n{\n\"workplace_id\": 1,\n\"id\": 18,\n\"title\": \"Electrical Engineer\",\n\"start_date\": \"March 2018\",\n\"end_date\": \"February 2019\",\n\"is_current\": false\n},\n{\n\"workplace_id\": -1,\n\"name\": \"DreamOval Limited\",\n\"location\": \"Accra, Ghana\",\n\"title\": \"Software Engineer Intern\",\n\"start_date\": null,\n\"end_date\": null,\n\"is_current\": false\n}\n],\n\"count\": 2\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./users/update_work_xp.php",
    "groupTitle": "Users"
  }
] });
