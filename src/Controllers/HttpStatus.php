<?php

namespace Steodec\SteoFrameWork\Controllers;

enum HttpStatus: int
{
    case Continue            = 100;
    case Switching_Protocols = 101;
    case Early_Hints         = 103;
    case OK       = 200;
    case Created  = 201;
    case Accepted = 202;
    case Non_Authoritative_Information = 203;
    case No_Content        = 204;
    case Reset_Content     = 205;
    case Partial_Content   = 206;
    case Multiple_Choices  = 300;
    case Moved_Permanently = 301;
    case Found        = 302;
    case See_Other    = 303;
    case Not_Modified = 304;
    case Temporary_Redirect = 307;
    case Permanent_Redirect = 308;
    case Bad_Request        = 400;
    case Unauthorized       = 401;
    case Payment_Required   = 402;
    case Forbidden          = 403;
    case Not_Found          = 404;
    case Method_Not_Allowed = 405;
    case Not_Acceptable     = 406;
    case Proxy_Authentication_Required = 407;
    case Request_Timeout = 408;
    case Conflict        = 409;
    case Gone            = 410;
    case Length_Required = 411;
    case Precondition_Failed    = 412;
    case Payload_Too_Large      = 413;
    case URI_Too_Long           = 414;
    case Unsupported_Media_Type = 415;
    case Range_Not_Satisfiable  = 416;
    case Expectation_Failed     = 417;
    case teapot = 418;
    case Unprocessable_Entity = 422;
    case Too_Early            = 425;
    case Upgrade_Required     = 426;
    case Precondition_Required = 428;
    case Too_Many_Requests     = 429;
    case Request_Header_Fields_Too_Large = 431;
    case Unavailable_For_Legal_Reasons   = 451;
    case Internal_Server_Error           = 500;
    case Not_Implemented     = 501;
    case Bad_Gateway         = 502;
    case Service_Unavailable = 503;
    case Gateway_Timeout     = 504;
    case HTTP_Version_Not_Supported = 505;
    case Variant_Also_Negotiates    = 506;
    case Insufficient_Storage       = 507;
    case Loop_Detected = 508;
    case Not_Extended  = 510;
    case Network_Authentication_Required = 511;
}//end enum
