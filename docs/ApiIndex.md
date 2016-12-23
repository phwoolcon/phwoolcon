# Phwoolcon API Reference

## Table of Contents

Classes:

* [Phwoolcon\Util\Counter\Adapter](#phwoolcon-util-counter-adapter)
    * [__construct](#--construct)
* [Phwoolcon\Aliases](#phwoolcon-aliases)
    * [register](#register)
* [Phwoolcon\Util\Counter\Adapter\Auto](#phwoolcon-util-counter-adapter-auto)
    * [__construct](#--construct-1)
    * [decrement](#decrement)
    * [increment](#increment)
    * [reset](#reset)
* [Phwoolcon\Queue\Adapter\Beanstalkd](#phwoolcon-queue-adapter-beanstalkd)
    * [__construct](#--construct-2)
    * [getConnection](#getconnection)
    * [getConnectionName](#getconnectionname)
    * [getDi](#getdi)
    * [getQueue](#getqueue)
    * [pop](#pop)
    * [push](#push)
    * [pushRaw](#pushraw)
* [Phwoolcon\Cache](#phwoolcon-cache)
    * [__callStatic](#--callstatic)
    * [decrement](#decrement-1)
    * [delete](#delete)
    * [exists](#exists)
    * [flush](#flush)
    * [get](#get)
    * [increment](#increment-1)
    * [queryKeys](#querykeys)
    * [register](#register-1)
    * [set](#set)
* [Phwoolcon\Util\Counter\Adapter\Cache](#phwoolcon-util-counter-adapter-cache)
    * [__construct](#--construct-3)
    * [decrement](#decrement-2)
    * [increment](#increment-2)
    * [reset](#reset-1)
* [Phwoolcon\Cli\Command\ClearCacheCommand](#phwoolcon-cli-command-clearcachecommand)
    * [__construct](#--construct-4)
    * [ask](#ask)
    * [comment](#comment)
    * [confirm](#confirm)
    * [createProgressBar](#createprogressbar)
    * [error](#error)
    * [execute](#execute)
    * [fire](#fire)
    * [getDi](#getdi-1)
    * [info](#info)
    * [question](#question)
    * [setDi](#setdi)
* [Phwoolcon\Cli](#phwoolcon-cli)
    * [getConsoleWidth](#getconsolewidth)
    * [register](#register-2)
* [Phwoolcon\Cli\Command](#phwoolcon-cli-command)
    * [__construct](#--construct-4)
    * [ask](#ask)
    * [comment](#comment)
    * [confirm](#confirm)
    * [createProgressBar](#createprogressbar)
    * [error](#error)
    * [execute](#execute)
    * [fire](#fire-1)
    * [getDi](#getdi-1)
    * [info](#info)
    * [question](#question)
    * [setDi](#setdi)
* [Phwoolcon\Config](#phwoolcon-config)
    * [clearCache](#clearcache)
    * [environment](#environment)
    * [get](#get-1)
    * [register](#register-3)
    * [runningUnitTest](#runningunittest)
    * [set](#set-1)
* [Phwoolcon\Model\Config](#phwoolcon-model-config)
    * [__call](#--call)
    * [addData](#adddata)
    * [afterFetch](#afterfetch)
    * [all](#all)
    * [buildParams](#buildparams)
    * [checkDataColumn](#checkdatacolumn)
    * [clearData](#cleardata)
    * [countSimple](#countsimple)
    * [findFirstSimple](#findfirstsimple)
    * [findSimple](#findsimple)
    * [generateDistributedId](#generatedistributedid)
    * [getAdditionalData](#getadditionaldata)
    * [getData](#getdata)
    * [getId](#getid)
    * [getInjectedClass](#getinjectedclass)
    * [getMessages](#getmessages)
    * [getStringMessages](#getstringmessages)
    * [getWriteConnection](#getwriteconnection)
    * [initialize](#initialize)
    * [isNew](#isnew)
    * [reset](#reset-2)
    * [saveConfig](#saveconfig)
    * [setData](#setdata)
    * [setId](#setid)
    * [setRelatedRecord](#setrelatedrecord)
    * [setup](#setup)
    * [sqlExecute](#sqlexecute)
    * [sqlFetchAll](#sqlfetchall)
    * [sqlFetchColumn](#sqlfetchcolumn)
    * [sqlFetchOne](#sqlfetchone)
    * [validation](#validation)
* [Phwoolcon\Controller](#phwoolcon-controller)
    * [addPageTitle](#addpagetitle)
    * [getBrowserCache](#getbrowsercache)
    * [getContentEtag](#getcontentetag)
    * [initialize](#initialize-1)
    * [render](#render)
    * [setBrowserCache](#setbrowsercache)
    * [setBrowserCacheHeaders](#setbrowsercacheheaders)
* [Phwoolcon\Http\Cookie](#phwoolcon-http-cookie)
    * [delete](#delete-1)
    * [getResponseValue](#getresponsevalue)
* [Phwoolcon\Cookies](#phwoolcon-cookies)
    * [__callStatic](#--callstatic-1)
    * [delete](#delete-2)
    * [get](#get-2)
    * [register](#register-4)
    * [reset](#reset-3)
    * [set](#set-2)
    * [toArray](#toarray)
* [Phwoolcon\Util\Counter](#phwoolcon-util-counter)
    * [decrement](#decrement-3)
    * [increment](#increment-3)
    * [register](#register-5)
    * [reset](#reset-4)
* [Phwoolcon\Crypt](#phwoolcon-crypt)
    * [opensslDecrypt](#openssldecrypt)
    * [opensslEncrypt](#opensslencrypt)
    * [reset](#reset-5)
* [Phwoolcon\Exception\Http\CsrfException](#phwoolcon-exception-http-csrfexception)
    * [__construct](#--construct-5)
    * [getHeaders](#getheaders)
    * [toResponse](#toresponse)
* [Phwoolcon\Assets\Resource\Css](#phwoolcon-assets-resource-css)
    * [concatenateHash](#concatenatehash)
    * [getContent](#getcontent)
    * [setBasePath](#setbasepath)
    * [setRunningUnitTests](#setrunningunittests)
* [Phwoolcon\DateTime](#phwoolcon-datetime)
* [Phwoolcon\Db](#phwoolcon-db)
    * [__construct](#--construct-6)
    * [clearMetadata](#clearmetadata)
    * [connection](#connection)
    * [disconnect](#disconnect)
    * [getDefaultTableCharset](#getdefaulttablecharset)
    * [reconnect](#reconnect)
    * [register](#register-6)
* [Phwoolcon\DiFix](#phwoolcon-difix)
    * [register](#register-7)
* [Phwoolcon\Router\Filter\DisableCsrfFilter](#phwoolcon-router-filter-disablecsrffilter)
    * [__invoke](#--invoke)
    * [instance](#instance)
* [Phwoolcon\Router\Filter\DisableSessionFilter](#phwoolcon-router-filter-disablesessionfilter)
    * [__invoke](#--invoke)
    * [instance](#instance)
* [Phwoolcon\Events](#phwoolcon-events)
    * [__callStatic](#--callstatic-2)
    * [attach](#attach)
    * [detach](#detach)
    * [detachAll](#detachall)
    * [fire](#fire-2)
    * [register](#register-8)
* [Phwoolcon\Queue\FailedLoggerDb](#phwoolcon-queue-failedloggerdb)
    * [__construct](#--construct-7)
    * [log](#log)
* [Phwoolcon\Exception\Http\ForbiddenException](#phwoolcon-exception-http-forbiddenexception)
    * [__construct](#--construct-8)
    * [getHeaders](#getheaders)
    * [toResponse](#toresponse)
* [Phwoolcon\Exception\HttpException](#phwoolcon-exception-httpexception)
    * [__construct](#--construct-5)
    * [getHeaders](#getheaders)
    * [toResponse](#toresponse)
* [Phwoolcon\I18n](#phwoolcon-i18n)
    * [__construct](#--construct-9)
    * [checkMobile](#checkmobile)
    * [clearCache](#clearcache-1)
    * [exists](#exists-1)
    * [formatPrice](#formatprice)
    * [getAvailableLocales](#getavailablelocales)
    * [getCurrentLocale](#getcurrentlocale)
    * [loadLocale](#loadlocale)
    * [query](#query)
    * [register](#register-9)
    * [reset](#reset-6)
    * [setLocale](#setlocale)
    * [staticReset](#staticreset)
    * [translate](#translate)
    * [useMultiLocale](#usemultilocale)
* [Phwoolcon\Model\MetaData\InCache](#phwoolcon-model-metadata-incache)
    * [getNonPrimaryKeyAttributes](#getnonprimarykeyattributes)
    * [read](#read)
    * [reset](#reset-7)
    * [write](#write)
* [Phwoolcon\Queue\Adapter\Beanstalkd\Job](#phwoolcon-queue-adapter-beanstalkd-job)
    * [__construct](#--construct-10)
    * [attempts](#attempts)
    * [bury](#bury)
    * [delete](#delete-3)
    * [fire](#fire-3)
    * [getJobId](#getjobid)
    * [getName](#getname)
    * [getQueue](#getqueue-1)
    * [getQueueName](#getqueuename)
    * [getRawBody](#getrawbody)
    * [getRawJob](#getrawjob)
    * [isDeleted](#isdeleted)
    * [release](#release)
* [Phwoolcon\Assets\Resource\Js](#phwoolcon-assets-resource-js)
    * [concatenateHash](#concatenatehash)
    * [getContent](#getcontent)
    * [setBasePath](#setbasepath)
    * [setRunningUnitTests](#setrunningunittests)
* [Phwoolcon\Queue\Listener](#phwoolcon-queue-listener)
    * [pop](#pop-1)
    * [process](#process)
* [Phwoolcon\Model\DynamicTrait\Loader](#phwoolcon-model-dynamictrait-loader)
    * [autoLoad](#autoload)
    * [register](#register-10)
* [Phwoolcon\Log](#phwoolcon-log)
    * [debug](#debug)
    * [error](#error-1)
    * [exception](#exception)
    * [info](#info-1)
    * [log](#log-1)
    * [register](#register-11)
    * [warning](#warning)
* [Phwoolcon\Session\Adapter\Memcached](#phwoolcon-session-adapter-memcached)
    * [__construct](#--construct-11)
    * [clear](#clear)
    * [clearFormData](#clearformdata)
    * [end](#end)
    * [flush](#flush-1)
    * [generateCsrfToken](#generatecsrftoken)
    * [get](#get-3)
    * [getCsrfToken](#getcsrftoken)
    * [getFormData](#getformdata)
    * [getLibmemcached](#getlibmemcached)
    * [readCookieAndStart](#readcookieandstart)
    * [regenerateId](#regenerateid)
    * [rememberFormData](#rememberformdata)
    * [remove](#remove)
    * [set](#set-3)
    * [setCookie](#setcookie)
    * [start](#start)
* [Phwoolcon\Cli\Command\Migrate](#phwoolcon-cli-command-migrate)
    * [__construct](#--construct-4)
    * [ask](#ask)
    * [cleanMigrationsTable](#cleanmigrationstable)
    * [clearMigratedCache](#clearmigratedcache)
    * [comment](#comment)
    * [confirm](#confirm)
    * [createProgressBar](#createprogressbar)
    * [error](#error)
    * [execute](#execute-1)
    * [fire](#fire-4)
    * [getDefaultTableCharset](#getdefaulttablecharset-1)
    * [getDi](#getdi-1)
    * [info](#info)
    * [question](#question)
    * [setDi](#setdi)
* [Phwoolcon\Cli\Command\MigrateCreate](#phwoolcon-cli-command-migratecreate)
    * [__construct](#--construct-4)
    * [ask](#ask)
    * [comment](#comment)
    * [confirm](#confirm)
    * [createProgressBar](#createprogressbar)
    * [error](#error)
    * [execute](#execute)
    * [fire](#fire-5)
    * [getDi](#getdi-1)
    * [info](#info)
    * [question](#question)
    * [setDi](#setdi)
    * [template](#template)
* [Phwoolcon\Cli\Command\MigrateList](#phwoolcon-cli-command-migratelist)
    * [__construct](#--construct-4)
    * [ask](#ask)
    * [cleanMigrationsTable](#cleanmigrationstable)
    * [clearMigratedCache](#clearmigratedcache)
    * [comment](#comment)
    * [confirm](#confirm)
    * [createProgressBar](#createprogressbar)
    * [error](#error)
    * [execute](#execute)
    * [fire](#fire-6)
    * [getDefaultTableCharset](#getdefaulttablecharset-1)
    * [getDi](#getdi-1)
    * [info](#info)
    * [question](#question)
    * [setDi](#setdi)
* [Phwoolcon\Cli\Command\MigrateRevert](#phwoolcon-cli-command-migraterevert)
    * [__construct](#--construct-4)
    * [ask](#ask)
    * [cleanMigrationsTable](#cleanmigrationstable)
    * [clearMigratedCache](#clearmigratedcache)
    * [comment](#comment)
    * [confirm](#confirm)
    * [createProgressBar](#createprogressbar)
    * [error](#error)
    * [execute](#execute)
    * [fire](#fire-7)
    * [getDefaultTableCharset](#getdefaulttablecharset-1)
    * [getDi](#getdi-1)
    * [info](#info)
    * [question](#question)
    * [setDi](#setdi)
* [Phwoolcon\Model](#phwoolcon-model)
    * [__call](#--call)
    * [addData](#adddata)
    * [afterFetch](#afterfetch)
    * [buildParams](#buildparams)
    * [checkDataColumn](#checkdatacolumn)
    * [clearData](#cleardata)
    * [countSimple](#countsimple)
    * [findFirstSimple](#findfirstsimple)
    * [findSimple](#findsimple)
    * [generateDistributedId](#generatedistributedid)
    * [getAdditionalData](#getadditionaldata)
    * [getData](#getdata)
    * [getId](#getid)
    * [getInjectedClass](#getinjectedclass)
    * [getMessages](#getmessages-1)
    * [getStringMessages](#getstringmessages)
    * [getWriteConnection](#getwriteconnection-1)
    * [initialize](#initialize)
    * [isNew](#isnew)
    * [reset](#reset-2)
    * [setData](#setdata)
    * [setId](#setid)
    * [setRelatedRecord](#setrelatedrecord)
    * [setup](#setup)
    * [sqlExecute](#sqlexecute)
    * [sqlFetchAll](#sqlfetchall)
    * [sqlFetchColumn](#sqlfetchcolumn)
    * [sqlFetchOne](#sqlfetchone)
    * [validation](#validation)
* [Phwoolcon\Router\Filter\MultiFilter](#phwoolcon-router-filter-multifilter)
    * [__invoke](#--invoke-1)
    * [add](#add)
    * [instance](#instance-1)
    * [remove](#remove-1)
* [Phwoolcon\Db\Adapter\Pdo\Mysql](#phwoolcon-db-adapter-pdo-mysql)
* [Phwoolcon\Session\Adapter\Native](#phwoolcon-session-adapter-native)
    * [__construct](#--construct-12)
    * [clear](#clear)
    * [clearFormData](#clearformdata)
    * [end](#end)
    * [flush](#flush-2)
    * [generateCsrfToken](#generatecsrftoken)
    * [get](#get-3)
    * [getCsrfToken](#getcsrftoken)
    * [getFormData](#getformdata)
    * [readCookieAndStart](#readcookieandstart)
    * [regenerateId](#regenerateid)
    * [rememberFormData](#rememberformdata)
    * [remove](#remove)
    * [set](#set-3)
    * [setCookie](#setcookie)
    * [start](#start)
* [Phwoolcon\Exception\Http\NotFoundException](#phwoolcon-exception-http-notfoundexception)
    * [__construct](#--construct-13)
    * [getHeaders](#getheaders)
    * [toResponse](#toresponse)
* [Phwoolcon\Util\Reflection\Stringify\Parameter](#phwoolcon-util-reflection-stringify-parameter)
    * [cast](#cast)
* [Phwoolcon\Payload](#phwoolcon-payload)
    * [__call](#--call-1)
    * [__construct](#--construct-14)
    * [create](#create)
    * [getData](#getdata-1)
    * [hasData](#hasdata)
    * [setData](#setdata-1)
* [Phwoolcon\View\Engine\Php](#phwoolcon-view-engine-php)
    * [__call](#--call-2)
    * [__construct](#--construct-15)
    * [include](#include)
    * [processInclude](#processinclude)
* [Phwoolcon\Queue](#phwoolcon-queue)
    * [__construct](#--construct-16)
    * [connection](#connection-1)
    * [getFailLogger](#getfaillogger)
    * [register](#register-12)
* [Phwoolcon\Exception\QueueException](#phwoolcon-exception-queueexception)
* [Phwoolcon\Util\Counter\Adapter\Rds](#phwoolcon-util-counter-adapter-rds)
    * [__construct](#--construct-17)
    * [decrement](#decrement-4)
    * [increment](#increment-4)
    * [reset](#reset-8)
* [Phwoolcon\Cache\Backend\Redis](#phwoolcon-cache-backend-redis)
    * [_connect](#-connect)
    * [decrement](#decrement-5)
    * [delete](#delete-4)
    * [exists](#exists-2)
    * [flush](#flush-3)
    * [get](#get-4)
    * [increment](#increment-5)
    * [queryKeys](#querykeys-1)
    * [save](#save)
* [Phwoolcon\Session\Adapter\Redis](#phwoolcon-session-adapter-redis)
    * [__construct](#--construct-18)
    * [clear](#clear)
    * [clearFormData](#clearformdata)
    * [end](#end)
    * [flush](#flush-4)
    * [generateCsrfToken](#generatecsrftoken)
    * [get](#get-3)
    * [getCsrfToken](#getcsrftoken)
    * [getFormData](#getformdata)
    * [getRedis](#getredis)
    * [readCookieAndStart](#readcookieandstart)
    * [regenerateId](#regenerateid)
    * [rememberFormData](#rememberformdata)
    * [remove](#remove)
    * [set](#set-3)
    * [setCookie](#setcookie)
    * [start](#start)
* [Phwoolcon\Router](#phwoolcon-router)
    * [__construct](#--construct-19)
    * [add](#add-1)
    * [addRoutes](#addroutes)
    * [checkCsrfToken](#checkcsrftoken)
    * [clearCache](#clearcache-2)
    * [disableCsrfCheck](#disablecsrfcheck)
    * [disableSession](#disablesession)
    * [dispatch](#dispatch)
    * [generateErrorPage](#generateerrorpage)
    * [getCurrentUri](#getcurrenturi)
    * [liteHandle](#litehandle)
    * [prefix](#prefix)
    * [quickAdd](#quickadd)
    * [register](#register-13)
    * [reset](#reset-9)
    * [staticReset](#staticreset-1)
    * [throw404Exception](#throw404exception)
    * [throwCsrfException](#throwcsrfexception)
    * [useLiteHandler](#uselitehandler)
* [Phwoolcon\Security](#phwoolcon-security)
    * [prepareSignatureData](#preparesignaturedata)
    * [sha256](#sha256)
    * [signArrayHmacSha256](#signarrayhmacsha256)
    * [signArrayMd5](#signarraymd5)
    * [signArraySha256](#signarraysha256)
* [Phwoolcon\Daemon\Service](#phwoolcon-daemon-service)
    * [__construct](#--construct-20)
    * [choosePort](#chooseport)
    * [getName](#getname-1)
    * [onManagerStart](#onmanagerstart)
    * [onReceive](#onreceive)
    * [onShutdown](#onshutdown)
    * [onStart](#onstart)
    * [onWorkerStart](#onworkerstart)
    * [profileReceive](#profilereceive)
    * [register](#register-14)
    * [reset](#reset-10)
    * [sendCommand](#sendcommand)
    * [setCliCommand](#setclicommand)
    * [shift](#shift)
    * [showStatus](#showstatus)
    * [start](#start-1)
    * [stop](#stop)
* [Phwoolcon\Cli\Command\ServiceCommand](#phwoolcon-cli-command-servicecommand)
    * [__construct](#--construct-4)
    * [ask](#ask)
    * [comment](#comment)
    * [confirm](#confirm)
    * [createProgressBar](#createprogressbar)
    * [error](#error)
    * [execute](#execute)
    * [fire](#fire-8)
    * [getDi](#getdi-1)
    * [info](#info)
    * [question](#question)
    * [setDi](#setdi)
* [Phwoolcon\Session](#phwoolcon-session)
    * [__callStatic](#--callstatic-3)
    * [clear](#clear-1)
    * [clearFormData](#clearformdata-1)
    * [destroy](#destroy)
    * [end](#end-1)
    * [flush](#flush-5)
    * [generateCsrfToken](#generatecsrftoken-1)
    * [generateRandomString](#generaterandomstring)
    * [get](#get-5)
    * [getCsrfToken](#getcsrftoken-1)
    * [getFormData](#getformdata-1)
    * [getId](#getid-1)
    * [getName](#getname-2)
    * [getOptions](#getoptions)
    * [has](#has)
    * [isStarted](#isstarted)
    * [regenerateId](#regenerateid-1)
    * [register](#register-15)
    * [rememberFormData](#rememberformdata-1)
    * [remove](#remove-2)
    * [set](#set-4)
    * [setCookie](#setcookie-1)
    * [setId](#setid-1)
    * [setName](#setname)
    * [setOptions](#setoptions)
    * [start](#start-2)
    * [status](#status)
* [Phwoolcon\Exception\SessionException](#phwoolcon-exception-sessionexception)
* [Phwoolcon\Cli\Output\Stream](#phwoolcon-cli-output-stream)
    * [__construct](#--construct-21)
    * [dir_closedir](#dir-closedir)
    * [dir_opendir](#dir-opendir)
    * [dir_readdir](#dir-readdir)
    * [dir_rewinddir](#dir-rewinddir)
    * [mkdir](#mkdir)
    * [rename](#rename)
    * [rmdir](#rmdir)
    * [stream_cast](#stream-cast)
    * [stream_close](#stream-close)
    * [stream_eof](#stream-eof)
    * [stream_flush](#stream-flush)
    * [stream_lock](#stream-lock)
    * [stream_metadata](#stream-metadata)
    * [stream_open](#stream-open)
    * [stream_read](#stream-read)
    * [stream_seek](#stream-seek)
    * [stream_set_option](#stream-set-option)
    * [stream_stat](#stream-stat)
    * [stream_tell](#stream-tell)
    * [stream_truncate](#stream-truncate)
    * [stream_write](#stream-write)
    * [unlink](#unlink)
    * [url_stat](#url-stat)
* [Phwoolcon\Text](#phwoolcon-text)
    * [ellipsis](#ellipsis)
    * [escapeHtml](#escapehtml)
    * [padOrTruncate](#padortruncate)
    * [token](#token)
* [Phwoolcon\Util\Timer](#phwoolcon-util-timer)
    * [start](#start-3)
    * [stop](#stop-1)
* [Phwoolcon\Model\User](#phwoolcon-model-user)
    * [__call](#--call)
    * [addData](#adddata)
    * [afterFetch](#afterfetch)
    * [buildParams](#buildparams)
    * [checkDataColumn](#checkdatacolumn)
    * [clearData](#cleardata)
    * [countSimple](#countsimple)
    * [findFirstSimple](#findfirstsimple)
    * [findSimple](#findsimple)
    * [generateDistributedId](#generatedistributedid)
    * [getAdditionalData](#getadditionaldata)
    * [getAvatar](#getavatar)
    * [getData](#getdata)
    * [getEmail](#getemail)
    * [getId](#getid)
    * [getInjectedClass](#getinjectedclass)
    * [getMessages](#getmessages-2)
    * [getMobile](#getmobile)
    * [getRememberToken](#getremembertoken)
    * [getStringMessages](#getstringmessages)
    * [getUserProfile](#getuserprofile)
    * [getUsername](#getusername)
    * [getWriteConnection](#getwriteconnection-2)
    * [initialize](#initialize-2)
    * [isNew](#isnew)
    * [removeRememberToken](#removeremembertoken)
    * [reset](#reset-2)
    * [setData](#setdata)
    * [setId](#setid)
    * [setRelatedRecord](#setrelatedrecord)
    * [setRememberToken](#setremembertoken)
    * [setUserProfile](#setuserprofile)
    * [setUsername](#setusername)
    * [setup](#setup)
    * [sqlExecute](#sqlexecute)
    * [sqlFetchAll](#sqlfetchall)
    * [sqlFetchColumn](#sqlfetchcolumn)
    * [sqlFetchOne](#sqlfetchone)
    * [validation](#validation)
* [Phwoolcon\Model\UserProfile](#phwoolcon-model-userprofile)
    * [__call](#--call)
    * [addData](#adddata)
    * [afterFetch](#afterfetch)
    * [buildParams](#buildparams)
    * [checkDataColumn](#checkdatacolumn)
    * [clearData](#cleardata)
    * [countSimple](#countsimple)
    * [findFirstSimple](#findfirstsimple)
    * [findSimple](#findsimple)
    * [generateAvatarUrl](#generateavatarurl)
    * [generateDistributedId](#generatedistributedid)
    * [getAdditionalData](#getadditionaldata)
    * [getAvatar](#getavatar-1)
    * [getData](#getdata)
    * [getExtraData](#getextradata)
    * [getId](#getid)
    * [getInjectedClass](#getinjectedclass)
    * [getMessages](#getmessages-3)
    * [getStringMessages](#getstringmessages)
    * [getWriteConnection](#getwriteconnection-3)
    * [initialize](#initialize-3)
    * [isNew](#isnew)
    * [reset](#reset-2)
    * [setData](#setdata)
    * [setExtraData](#setextradata)
    * [setId](#setid)
    * [setRelatedRecord](#setrelatedrecord)
    * [setup](#setup)
    * [sqlExecute](#sqlexecute)
    * [sqlFetchAll](#sqlfetchall)
    * [sqlFetchColumn](#sqlfetchcolumn)
    * [sqlFetchOne](#sqlfetchone)
    * [validation](#validation)
* [Phwoolcon\View](#phwoolcon-view)
    * [__construct](#--construct-22)
    * [assets](#assets)
    * [clearAssetsCache](#clearassetscache)
    * [generateBodyJs](#generatebodyjs)
    * [generateHeadCss](#generateheadcss)
    * [generateHeadJs](#generateheadjs)
    * [generateIeHack](#generateiehack)
    * [generateIeHackBodyJs](#generateiehackbodyjs)
    * [getAbsoluteViewPath](#getabsoluteviewpath)
    * [getConfig](#getconfig)
    * [getCurrentTheme](#getcurrenttheme)
    * [getDebugWrapper](#getdebugwrapper)
    * [getPageDescription](#getpagedescription)
    * [getPageKeywords](#getpagekeywords)
    * [getPageLanguage](#getpagelanguage)
    * [getPageTitle](#getpagetitle)
    * [getParam](#getparam)
    * [getPhwoolconJsOptions](#getphwoolconjsoptions)
    * [isAdmin](#isadmin)
    * [loadAssets](#loadassets)
    * [make](#make)
    * [noFooter](#nofooter)
    * [noHeader](#noheader)
    * [register](#register-16)
    * [render](#render-1)
    * [reset](#reset-11)
    * [setContent](#setcontent)
    * [setParams](#setparams)
* [Phwoolcon\View\Widget](#phwoolcon-view-widget)
    * [__callStatic](#--callstatic-4)
    * [define](#define)
    * [ideHelperGenerator](#idehelpergenerator)
    * [label](#label)
    * [multipleChoose](#multiplechoose)
    * [singleChoose](#singlechoose)
* [Phwoolcon\Exception\WidgetException](#phwoolcon-exception-widgetexception)

Functions:

* [__](#--)
* [_e](#-e)
* [array_forget](#array-forget)
* [array_set](#array-set)
* [arraySortedMerge](#arraysortedmerge)
* [base62encode](#base62encode)
* [copyDirMerge](#copydirmerge)
* [copyDirOverride](#copydiroverride)
* [copyDirReplace](#copydirreplace)
* [fileSaveArray](#filesavearray)
* [fileSaveInclude](#filesaveinclude)
* [fnGet](#fnget)
* [getRelativePath](#getrelativepath)
* [isHttpUrl](#ishttpurl)
* [migrationPath](#migrationpath)
* [opcache_invalidate](#opcache-invalidate)
* [opcache_reset](#opcache-reset)
* [price](#price)
* [random_bytes](#random-bytes)
* [removeDir](#removedir)
* [secureUrl](#secureurl)
* [showTrace](#showtrace)
* [storagePath](#storagepath)
* [symlinkDirOverride](#symlinkdiroverride)
* [symlinkRelative](#symlinkrelative)
* [url](#url)

<a name="phwoolcon-util-counter-adapter">&nbsp;</a>

## Phwoolcon\Util\Counter\Adapter <kbd>abstract</kbd>




* **Implements**: \Phwoolcon\Util\Counter\AdapterInterface


<a name="--construct">&nbsp;</a>

### __construct
```php
Adapter::__construct(  $options )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **mixed** | &nbsp; |




---

<a name="phwoolcon-aliases">&nbsp;</a>

## Phwoolcon\Aliases






<a name="register">&nbsp;</a>

### register <kbd>static</kbd>
```php
Aliases::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="phwoolcon-util-counter-adapter-auto">&nbsp;</a>

## Phwoolcon\Util\Counter\Adapter\Auto




* Parent class: Phwoolcon\Util\Counter\Adapter


<a name="--construct-1">&nbsp;</a>

### __construct
```php
Auto::__construct(  $options )
```






* **Overrides** \Phwoolcon\Util\Counter\Adapter::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **mixed** | &nbsp; |




---

<a name="decrement">&nbsp;</a>

### decrement
```php
Auto::decrement(  $keyName,  $value = 1 )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="increment">&nbsp;</a>

### increment
```php
Auto::increment(  $keyName,  $value = 1 )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="reset">&nbsp;</a>

### reset
```php
Auto::reset(  $keyName )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |




---

<a name="phwoolcon-queue-adapter-beanstalkd">&nbsp;</a>

## Phwoolcon\Queue\Adapter\Beanstalkd
Class Beanstalkd



* **Implements**: \Phwoolcon\Queue\AdapterInterface


<a name="--construct-2">&nbsp;</a>

### __construct
```php
Beanstalkd::__construct( \Phalcon\Di $di, array $options,  $connectionName )
```






* **Inherits** \Phwoolcon\Queue\AdapterTrait::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |
| $options | **array** | &nbsp; |
| $connectionName | **mixed** | &nbsp; |




---

<a name="getconnection">&nbsp;</a>

### getConnection <kbd>magic</kbd>
```php
Beanstalkd::getConnection(  ): \Pheanstalk\Pheanstalk
```






* **Inherits** \Phwoolcon\Queue\AdapterTrait::getConnection()




---

<a name="getconnectionname">&nbsp;</a>

### getConnectionName
```php
Beanstalkd::getConnectionName(  ): string
```






* **Inherits** \Phwoolcon\Queue\AdapterTrait::getConnectionName()




---

<a name="getdi">&nbsp;</a>

### getDi
```php
Beanstalkd::getDi(  )
```






* **Inherits** \Phwoolcon\Queue\AdapterTrait::getDi()




---

<a name="getqueue">&nbsp;</a>

### getQueue
```php
Beanstalkd::getQueue( string|null $queue ): string
```

Get the queue or return the default.




* **Inherits** \Phwoolcon\Queue\AdapterTrait::getQueue()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $queue | **string&#124;null** | &nbsp; |




---

<a name="pop">&nbsp;</a>

### pop
```php
Beanstalkd::pop( string $queue = null ): \Phwoolcon\Queue\Adapter\JobInterface|\Phwoolcon\Queue\Adapter\JobTrait|null
```

Pop the next job off of the queue.




* **Implements** \Phwoolcon\Queue\AdapterInterface::pop()
* **Overrides** \Phwoolcon\Queue\AdapterTrait::pop()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $queue | **string** | &nbsp; |




---

<a name="push">&nbsp;</a>

### push
```php
Beanstalkd::push(  $worker,  $data = '',  $queue = null, array $options = array() )
```






* **Inherits** \Phwoolcon\Queue\AdapterTrait::push()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $worker | **mixed** | &nbsp; |
| $data | **mixed** | &nbsp; |
| $queue | **mixed** | &nbsp; |
| $options | **array** | &nbsp; |




---

<a name="pushraw">&nbsp;</a>

### pushRaw
```php
Beanstalkd::pushRaw( string $payload, string $queue = null, array $options = array() ): mixed
```

Push a raw payload onto the queue.




* **Implements** \Phwoolcon\Queue\AdapterInterface::pushRaw()
* **Overrides** \Phwoolcon\Queue\AdapterTrait::pushRaw()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $payload | **string** | &nbsp; |
| $queue | **string** | &nbsp; |
| $options | **array** | &nbsp; |




---

<a name="phwoolcon-cache">&nbsp;</a>

## Phwoolcon\Cache
Class Cache





<a name="--callstatic">&nbsp;</a>

### __callStatic <kbd>static</kbd>
```php
Cache::__callStatic(  $name,  $arguments )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $arguments | **mixed** | &nbsp; |




---

<a name="decrement-1">&nbsp;</a>

### decrement <kbd>magic</kbd>
```php
Cache::decrement( string $keyName = null, integer $value = null ): integer
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **string** | &nbsp; |
| $value | **integer** | &nbsp; |




---

<a name="delete">&nbsp;</a>

### delete <kbd>static</kbd>
```php
Cache::delete(  $key )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="exists">&nbsp;</a>

### exists <kbd>magic</kbd>
```php
Cache::exists( string $keyName = null ): boolean
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **string** | &nbsp; |




---

<a name="flush">&nbsp;</a>

### flush <kbd>static</kbd>
```php
Cache::flush(  )
```










---

<a name="get">&nbsp;</a>

### get <kbd>static</kbd>
```php
Cache::get(  $key,  $default = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="increment-1">&nbsp;</a>

### increment <kbd>magic</kbd>
```php
Cache::increment( string $keyName = null, integer $value = null ): integer
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **string** | &nbsp; |
| $value | **integer** | &nbsp; |




---

<a name="querykeys">&nbsp;</a>

### queryKeys <kbd>magic</kbd>
```php
Cache::queryKeys( string $prefix = null ): array
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $prefix | **string** | &nbsp; |




---

<a name="register-1">&nbsp;</a>

### register <kbd>static</kbd>
```php
Cache::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="set">&nbsp;</a>

### set <kbd>static</kbd>
```php
Cache::set(  $key,  $value,  $ttl = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |
| $ttl | **mixed** | &nbsp; |




---

<a name="phwoolcon-util-counter-adapter-cache">&nbsp;</a>

## Phwoolcon\Util\Counter\Adapter\Cache




* Parent class: Phwoolcon\Util\Counter\Adapter


<a name="--construct-3">&nbsp;</a>

### __construct
```php
Cache::__construct(  $options )
```






* **Overrides** \Phwoolcon\Util\Counter\Adapter::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **mixed** | &nbsp; |




---

<a name="decrement-2">&nbsp;</a>

### decrement
```php
Cache::decrement(  $keyName,  $value = 1 )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="increment-2">&nbsp;</a>

### increment
```php
Cache::increment(  $keyName,  $value = 1 )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="reset-1">&nbsp;</a>

### reset
```php
Cache::reset(  $keyName )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |




---

<a name="phwoolcon-cli-command-clearcachecommand">&nbsp;</a>

## Phwoolcon\Cli\Command\ClearCacheCommand




* Parent class: Phwoolcon\Cli\Command


<a name="--construct-4">&nbsp;</a>

### __construct
```php
ClearCacheCommand::__construct(  $name, \Phalcon\Di $di )
```






* **Inherits** \Phwoolcon\Cli\Command::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="ask">&nbsp;</a>

### ask
```php
ClearCacheCommand::ask(  $question,  $default = null )
```






* **Inherits** \Phwoolcon\Cli\Command::ask()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="comment">&nbsp;</a>

### comment
```php
ClearCacheCommand::comment(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::comment()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="confirm">&nbsp;</a>

### confirm
```php
ClearCacheCommand::confirm(  $question,  $default = true )
```






* **Inherits** \Phwoolcon\Cli\Command::confirm()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="createprogressbar">&nbsp;</a>

### createProgressBar
```php
ClearCacheCommand::createProgressBar(  $max )
```






* **Inherits** \Phwoolcon\Cli\Command::createProgressBar()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $max | **mixed** | &nbsp; |




---

<a name="error">&nbsp;</a>

### error
```php
ClearCacheCommand::error(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::error()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="execute">&nbsp;</a>

### execute
```php
ClearCacheCommand::execute( \Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output )
```






* **Inherits** \Phwoolcon\Cli\Command::execute()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $input | **\Symfony\Component\Console\Input\InputInterface** | &nbsp; |
| $output | **\Symfony\Component\Console\Output\OutputInterface** | &nbsp; |




---

<a name="fire">&nbsp;</a>

### fire
```php
ClearCacheCommand::fire(  )
```






* **Overrides** \Phwoolcon\Cli\Command::fire()




---

<a name="getdi-1">&nbsp;</a>

### getDi
```php
ClearCacheCommand::getDi(  ): \Phalcon\Di
```






* **Inherits** \Phwoolcon\Cli\Command::getDi()




---

<a name="info">&nbsp;</a>

### info
```php
ClearCacheCommand::info(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::info()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="question">&nbsp;</a>

### question
```php
ClearCacheCommand::question(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::question()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="setdi">&nbsp;</a>

### setDi
```php
ClearCacheCommand::setDi( \Phalcon\Di $di ): $this
```






* **Inherits** \Phwoolcon\Cli\Command::setDi()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="phwoolcon-cli">&nbsp;</a>

## Phwoolcon\Cli






<a name="getconsolewidth">&nbsp;</a>

### getConsoleWidth <kbd>static</kbd>
```php
Cli::getConsoleWidth(  )
```










---

<a name="register-2">&nbsp;</a>

### register <kbd>static</kbd>
```php
Cli::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="phwoolcon-cli-command">&nbsp;</a>

## Phwoolcon\Cli\Command <kbd>abstract</kbd>






<a name="--construct-4">&nbsp;</a>

### __construct
```php
Command::__construct(  $name, \Phalcon\Di $di )
```






* **Inherits** \Phwoolcon\Cli\Command::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="ask">&nbsp;</a>

### ask
```php
Command::ask(  $question,  $default = null )
```






* **Inherits** \Phwoolcon\Cli\Command::ask()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="comment">&nbsp;</a>

### comment
```php
Command::comment(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::comment()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="confirm">&nbsp;</a>

### confirm
```php
Command::confirm(  $question,  $default = true )
```






* **Inherits** \Phwoolcon\Cli\Command::confirm()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="createprogressbar">&nbsp;</a>

### createProgressBar
```php
Command::createProgressBar(  $max )
```






* **Inherits** \Phwoolcon\Cli\Command::createProgressBar()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $max | **mixed** | &nbsp; |




---

<a name="error">&nbsp;</a>

### error
```php
Command::error(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::error()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="execute">&nbsp;</a>

### execute
```php
Command::execute( \Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output )
```






* **Inherits** \Phwoolcon\Cli\Command::execute()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $input | **\Symfony\Component\Console\Input\InputInterface** | &nbsp; |
| $output | **\Symfony\Component\Console\Output\OutputInterface** | &nbsp; |




---

<a name="fire-1">&nbsp;</a>

### fire
```php
Command::fire(  )
```










---

<a name="getdi-1">&nbsp;</a>

### getDi
```php
Command::getDi(  ): \Phalcon\Di
```






* **Inherits** \Phwoolcon\Cli\Command::getDi()




---

<a name="info">&nbsp;</a>

### info
```php
Command::info(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::info()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="question">&nbsp;</a>

### question
```php
Command::question(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::question()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="setdi">&nbsp;</a>

### setDi
```php
Command::setDi( \Phalcon\Di $di ): $this
```






* **Inherits** \Phwoolcon\Cli\Command::setDi()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="phwoolcon-config">&nbsp;</a>

## Phwoolcon\Config






<a name="clearcache">&nbsp;</a>

### clearCache <kbd>static</kbd>
```php
Config::clearCache(  )
```










---

<a name="environment">&nbsp;</a>

### environment <kbd>static</kbd>
```php
Config::environment(  )
```










---

<a name="get-1">&nbsp;</a>

### get <kbd>static</kbd>
```php
Config::get(  $key = null,  $defaultValue = null ): mixed
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | string |
| $defaultValue | **mixed** | mixed |




---

<a name="register-3">&nbsp;</a>

### register <kbd>static</kbd>
```php
Config::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="runningunittest">&nbsp;</a>

### runningUnitTest <kbd>static</kbd>
```php
Config::runningUnitTest(  )
```










---

<a name="set-1">&nbsp;</a>

### set <kbd>static</kbd>
```php
Config::set( string $key, mixed $value ): mixed
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **string** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="phwoolcon-model-config">&nbsp;</a>

## Phwoolcon\Model\Config
Class Model



* Parent class: Phwoolcon\Model


<a name="--call">&nbsp;</a>

### __call
```php
Config::__call(  $method,  $arguments )
```






* **Inherits** \Phwoolcon\Model::__call()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $method | **mixed** | &nbsp; |
| $arguments | **mixed** | &nbsp; |




---

<a name="adddata">&nbsp;</a>

### addData
```php
Config::addData( array $data )
```






* **Inherits** \Phwoolcon\Model::addData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $data | **array** | &nbsp; |




---

<a name="afterfetch">&nbsp;</a>

### afterFetch
```php
Config::afterFetch(  )
```






* **Inherits** \Phwoolcon\Model::afterFetch()




---

<a name="all">&nbsp;</a>

### all <kbd>static</kbd>
```php
Config::all(  )
```










---

<a name="buildparams">&nbsp;</a>

### buildParams <kbd>static</kbd>
```php
Config::buildParams(  $conditions = array(), array $bind = array(), string $orderBy = null, string $columns = null, string|integer $limit = null ): array
```






* **Inherits** \Phwoolcon\Model::buildParams()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **mixed** | &nbsp; |
| $bind | **array** | &nbsp; |
| $orderBy | **string** | &nbsp; |
| $columns | **string** | &nbsp; |
| $limit | **string&#124;integer** | &nbsp; |




---

<a name="checkdatacolumn">&nbsp;</a>

### checkDataColumn
```php
Config::checkDataColumn(  $column = null )
```






* **Inherits** \Phwoolcon\Model::checkDataColumn()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $column | **mixed** | &nbsp; |




---

<a name="cleardata">&nbsp;</a>

### clearData
```php
Config::clearData(  )
```






* **Inherits** \Phwoolcon\Model::clearData()




---

<a name="countsimple">&nbsp;</a>

### countSimple <kbd>static</kbd>
```php
Config::countSimple( array $conditions = array(), array $bind = array() ): mixed
```






* **Inherits** \Phwoolcon\Model::countSimple()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **array** | &nbsp; |
| $bind | **array** | &nbsp; |




---

<a name="findfirstsimple">&nbsp;</a>

### findFirstSimple <kbd>static</kbd>
```php
Config::findFirstSimple( array|string $conditions, array $bind = array(), string $order = null, string $columns = null ): $this|false
```






* **Inherits** \Phwoolcon\Model::findFirstSimple()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **array&#124;string** | &nbsp; |
| $bind | **array** | &nbsp; |
| $order | **string** | &nbsp; |
| $columns | **string** | &nbsp; |




---

<a name="findsimple">&nbsp;</a>

### findSimple <kbd>static</kbd>
```php
Config::findSimple(  $conditions = array(), array $bind = array(), string $order = null, string $columns = null, string|integer $limit = null ): \Phalcon\Mvc\Model\Resultset\Simple|\Phalcon\Mvc\Model\ResultsetInterface
```






* **Inherits** \Phwoolcon\Model::findSimple()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **mixed** | &nbsp; |
| $bind | **array** | &nbsp; |
| $order | **string** | &nbsp; |
| $columns | **string** | &nbsp; |
| $limit | **string&#124;integer** | &nbsp; |




---

<a name="generatedistributedid">&nbsp;</a>

### generateDistributedId
```php
Config::generateDistributedId(  )
```






* **Inherits** \Phwoolcon\Model::generateDistributedId()




---

<a name="getadditionaldata">&nbsp;</a>

### getAdditionalData
```php
Config::getAdditionalData(  $key = null )
```






* **Inherits** \Phwoolcon\Model::getAdditionalData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="getdata">&nbsp;</a>

### getData
```php
Config::getData(  $key = null )
```






* **Inherits** \Phwoolcon\Model::getData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="getid">&nbsp;</a>

### getId
```php
Config::getId(  )
```






* **Inherits** \Phwoolcon\Model::getId()




---

<a name="getinjectedclass">&nbsp;</a>

### getInjectedClass
```php
Config::getInjectedClass(  $class )
```






* **Inherits** \Phwoolcon\Model::getInjectedClass()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $class | **mixed** | &nbsp; |




---

<a name="getmessages">&nbsp;</a>

### getMessages <kbd>magic</kbd>
```php
Config::getMessages( string $filter = null ): array<mixed,\Phalcon\Mvc\Model\Message>
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $filter | **string** | &nbsp; |




---

<a name="getstringmessages">&nbsp;</a>

### getStringMessages
```php
Config::getStringMessages(  )
```






* **Inherits** \Phwoolcon\Model::getStringMessages()




---

<a name="getwriteconnection">&nbsp;</a>

### getWriteConnection <kbd>magic</kbd>
```php
Config::getWriteConnection(  ): \Phwoolcon\Db\Adapter\Pdo\Mysql|\Phalcon\Db\Adapter\Pdo
```










---

<a name="initialize">&nbsp;</a>

### initialize
```php
Config::initialize(  )
```

Runs once, only when the model instance is created at the first time




* **Inherits** \Phwoolcon\Model::initialize()




---

<a name="isnew">&nbsp;</a>

### isNew
```php
Config::isNew(  )
```






* **Inherits** \Phwoolcon\Model::isNew()




---

<a name="reset-2">&nbsp;</a>

### reset
```php
Config::reset(  )
```






* **Inherits** \Phwoolcon\Model::reset()




---

<a name="saveconfig">&nbsp;</a>

### saveConfig <kbd>static</kbd>
```php
Config::saveConfig(  $key,  $value )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setdata">&nbsp;</a>

### setData
```php
Config::setData(  $key,  $value = null )
```






* **Inherits** \Phwoolcon\Model::setData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setid">&nbsp;</a>

### setId
```php
Config::setId(  $id )
```






* **Inherits** \Phwoolcon\Model::setId()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $id | **mixed** | &nbsp; |




---

<a name="setrelatedrecord">&nbsp;</a>

### setRelatedRecord
```php
Config::setRelatedRecord(  $key,  $value )
```






* **Inherits** \Phwoolcon\Model::setRelatedRecord()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setup">&nbsp;</a>

### setup <kbd>static</kbd>
```php
Config::setup( array $options )
```






* **Inherits** \Phwoolcon\Model::setup()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **array** | &nbsp; |




---

<a name="sqlexecute">&nbsp;</a>

### sqlExecute
```php
Config::sqlExecute(  $sql, null $bind = null ): boolean
```






* **Inherits** \Phwoolcon\Model::sqlExecute()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="sqlfetchall">&nbsp;</a>

### sqlFetchAll
```php
Config::sqlFetchAll(  $sql, null $bind = null ): array
```






* **Inherits** \Phwoolcon\Model::sqlFetchAll()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="sqlfetchcolumn">&nbsp;</a>

### sqlFetchColumn
```php
Config::sqlFetchColumn(  $sql, null $bind = null ): mixed
```






* **Inherits** \Phwoolcon\Model::sqlFetchColumn()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="sqlfetchone">&nbsp;</a>

### sqlFetchOne
```php
Config::sqlFetchOne(  $sql, null $bind = null ): array
```






* **Inherits** \Phwoolcon\Model::sqlFetchOne()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="validation">&nbsp;</a>

### validation
```php
Config::validation(  )
```






* **Inherits** \Phwoolcon\Model::validation()




---

<a name="phwoolcon-controller">&nbsp;</a>

## Phwoolcon\Controller <kbd>abstract</kbd>
Class Controller





<a name="addpagetitle">&nbsp;</a>

### addPageTitle
```php
Controller::addPageTitle(  $title )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $title | **mixed** | &nbsp; |




---

<a name="getbrowsercache">&nbsp;</a>

### getBrowserCache
```php
Controller::getBrowserCache(  $pageId = null,  $type = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $pageId | **mixed** | &nbsp; |
| $type | **mixed** | &nbsp; |




---

<a name="getcontentetag">&nbsp;</a>

### getContentEtag
```php
Controller::getContentEtag(  &$content )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $content | **mixed** | &nbsp; |




---

<a name="initialize-1">&nbsp;</a>

### initialize
```php
Controller::initialize(  )
```










---

<a name="render">&nbsp;</a>

### render
```php
Controller::render(  $path,  $view, array $params = array() )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **mixed** | &nbsp; |
| $view | **mixed** | &nbsp; |
| $params | **array** | &nbsp; |




---

<a name="setbrowsercache">&nbsp;</a>

### setBrowserCache
```php
Controller::setBrowserCache(  $pageId = null,  $type = null,  $ttl = \Phwoolcon\Cache::TTL_ONE_WEEK )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $pageId | **mixed** | &nbsp; |
| $type | **mixed** | &nbsp; |
| $ttl | **mixed** | &nbsp; |




---

<a name="setbrowsercacheheaders">&nbsp;</a>

### setBrowserCacheHeaders
```php
Controller::setBrowserCacheHeaders(  $eTag,  $ttl = \Phwoolcon\Cache::TTL_ONE_WEEK )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $eTag | **mixed** | &nbsp; |
| $ttl | **mixed** | &nbsp; |




---

<a name="phwoolcon-http-cookie">&nbsp;</a>

## Phwoolcon\Http\Cookie
Class Cookie





<a name="delete-1">&nbsp;</a>

### delete
```php
Cookie::delete(  )
```










---

<a name="getresponsevalue">&nbsp;</a>

### getResponseValue
```php
Cookie::getResponseValue(  )
```










---

<a name="phwoolcon-cookies">&nbsp;</a>

## Phwoolcon\Cookies
Class Cookies





<a name="--callstatic-1">&nbsp;</a>

### __callStatic <kbd>static</kbd>
```php
Cookies::__callStatic(  $name,  $arguments )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $arguments | **mixed** | &nbsp; |




---

<a name="delete-2">&nbsp;</a>

### delete <kbd>magic</kbd>
```php
Cookies::delete( string $name ): boolean
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **string** | &nbsp; |




---

<a name="get-2">&nbsp;</a>

### get <kbd>magic</kbd>
```php
Cookies::get( string $name ): \Phwoolcon\Http\Cookie
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **string** | &nbsp; |




---

<a name="register-4">&nbsp;</a>

### register <kbd>static</kbd>
```php
Cookies::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="reset-3">&nbsp;</a>

### reset <kbd>magic</kbd>
```php
Cookies::reset(  ): \Phalcon\Http\Response\Cookies
```










---

<a name="set-2">&nbsp;</a>

### set <kbd>static</kbd>
```php
Cookies::set( string $name, mixed $value = null, integer $expire, string $path = null, boolean $secure = null, string $domain = null, boolean $httpOnly = null ): \Phalcon\Http\Response\Cookies
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **string** | &nbsp; |
| $value | **mixed** | &nbsp; |
| $expire | **integer** | &nbsp; |
| $path | **string** | &nbsp; |
| $secure | **boolean** | &nbsp; |
| $domain | **string** | &nbsp; |
| $httpOnly | **boolean** | &nbsp; |




---

<a name="toarray">&nbsp;</a>

### toArray <kbd>static</kbd>
```php
Cookies::toArray(  ): array<mixed,\Phwoolcon\Http\Cookie>
```










---

<a name="phwoolcon-util-counter">&nbsp;</a>

## Phwoolcon\Util\Counter






<a name="decrement-3">&nbsp;</a>

### decrement <kbd>static</kbd>
```php
Counter::decrement(  $keyName,  $value = 1 )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="increment-3">&nbsp;</a>

### increment <kbd>static</kbd>
```php
Counter::increment(  $keyName,  $value = 1 )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="register-5">&nbsp;</a>

### register <kbd>static</kbd>
```php
Counter::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="reset-4">&nbsp;</a>

### reset <kbd>static</kbd>
```php
Counter::reset(  $keyName )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |




---

<a name="phwoolcon-crypt">&nbsp;</a>

## Phwoolcon\Crypt






<a name="openssldecrypt">&nbsp;</a>

### opensslDecrypt <kbd>static</kbd>
```php
Crypt::opensslDecrypt(  $text,  $key = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $text | **mixed** | &nbsp; |
| $key | **mixed** | &nbsp; |




---

<a name="opensslencrypt">&nbsp;</a>

### opensslEncrypt <kbd>static</kbd>
```php
Crypt::opensslEncrypt(  $text,  $key = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $text | **mixed** | &nbsp; |
| $key | **mixed** | &nbsp; |




---

<a name="reset-5">&nbsp;</a>

### reset <kbd>static</kbd>
```php
Crypt::reset(  )
```










---

<a name="phwoolcon-exception-http-csrfexception">&nbsp;</a>

## Phwoolcon\Exception\Http\CsrfException




* Parent class: Phwoolcon\Exception\Http\ForbiddenException


<a name="--construct-5">&nbsp;</a>

### __construct
```php
CsrfException::__construct(  $message,  $code,  $headers = null )
```






* **Inherits** \Phwoolcon\Exception\HttpException::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $message | **mixed** | &nbsp; |
| $code | **mixed** | &nbsp; |
| $headers | **mixed** | &nbsp; |




---

<a name="getheaders">&nbsp;</a>

### getHeaders
```php
CsrfException::getHeaders(  )
```






* **Inherits** \Phwoolcon\Exception\HttpException::getHeaders()




---

<a name="toresponse">&nbsp;</a>

### toResponse
```php
CsrfException::toResponse(  )
```






* **Inherits** \Phwoolcon\Exception\HttpException::toResponse()




---

<a name="phwoolcon-assets-resource-css">&nbsp;</a>

## Phwoolcon\Assets\Resource\Css






<a name="concatenatehash">&nbsp;</a>

### concatenateHash
```php
Css::concatenateHash(  $previousHash )
```






* **Inherits** \Phwoolcon\Assets\ResourceTrait::concatenateHash()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $previousHash | **mixed** | &nbsp; |




---

<a name="getcontent">&nbsp;</a>

### getContent
```php
Css::getContent(  $basePath = null )
```






* **Inherits** \Phwoolcon\Assets\ResourceTrait::getContent()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $basePath | **mixed** | &nbsp; |




---

<a name="setbasepath">&nbsp;</a>

### setBasePath <kbd>static</kbd>
```php
Css::setBasePath(  $path )
```






* **Inherits** \Phwoolcon\Assets\ResourceTrait::setBasePath()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **mixed** | &nbsp; |




---

<a name="setrunningunittests">&nbsp;</a>

### setRunningUnitTests <kbd>static</kbd>
```php
Css::setRunningUnitTests(  $flag )
```






* **Inherits** \Phwoolcon\Assets\ResourceTrait::setRunningUnitTests()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $flag | **mixed** | &nbsp; |




---

<a name="phwoolcon-datetime">&nbsp;</a>

## Phwoolcon\DateTime






<a name="phwoolcon-db">&nbsp;</a>

## Phwoolcon\Db






<a name="--construct-6">&nbsp;</a>

### __construct
```php
Db::__construct(  $config )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $config | **mixed** | &nbsp; |




---

<a name="clearmetadata">&nbsp;</a>

### clearMetadata <kbd>static</kbd>
```php
Db::clearMetadata(  )
```










---

<a name="connection">&nbsp;</a>

### connection <kbd>static</kbd>
```php
Db::connection( string $name = null ): \Phalcon\Db\Adapter\Pdo|\Phwoolcon\Db\Adapter\Pdo\Mysql
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **string** | &nbsp; |




---

<a name="disconnect">&nbsp;</a>

### disconnect
```php
Db::disconnect(  $name )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |




---

<a name="getdefaulttablecharset">&nbsp;</a>

### getDefaultTableCharset <kbd>static</kbd>
```php
Db::getDefaultTableCharset( string $name = null ): string
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **string** | &nbsp; |




---

<a name="reconnect">&nbsp;</a>

### reconnect <kbd>static</kbd>
```php
Db::reconnect(  $name = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |




---

<a name="register-6">&nbsp;</a>

### register <kbd>static</kbd>
```php
Db::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="phwoolcon-difix">&nbsp;</a>

## Phwoolcon\DiFix






<a name="register-7">&nbsp;</a>

### register <kbd>static</kbd>
```php
DiFix::register( \Phalcon\Di $di )
```

Fix over clever di service resolver in phalcon 2.1.x:
let definition = \Closure::bind(definition, dependencyInjector)
which leads to php warning "Cannot bind an instance to a static closure"





**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="phwoolcon-router-filter-disablecsrffilter">&nbsp;</a>

## Phwoolcon\Router\Filter\DisableCsrfFilter




* **Implements**: \Phwoolcon\Router\FilterInterface


<a name="--invoke">&nbsp;</a>

### __invoke
```php
DisableCsrfFilter::__invoke( string $uri, \Phalcon\Mvc\Router\Route $route, \Phwoolcon\Router $router ): boolean
```






* **Inherits** \Phwoolcon\Router\FilterTrait::__invoke()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $uri | **string** | &nbsp; |
| $route | **\Phalcon\Mvc\Router\Route** | &nbsp; |
| $router | **\Phwoolcon\Router** | &nbsp; |




---

<a name="instance">&nbsp;</a>

### instance <kbd>static</kbd>
```php
DisableCsrfFilter::instance(  )
```






* **Inherits** \Phwoolcon\Router\FilterTrait::instance()




---

<a name="phwoolcon-router-filter-disablesessionfilter">&nbsp;</a>

## Phwoolcon\Router\Filter\DisableSessionFilter




* **Implements**: \Phwoolcon\Router\FilterInterface


<a name="--invoke">&nbsp;</a>

### __invoke
```php
DisableSessionFilter::__invoke( string $uri, \Phalcon\Mvc\Router\Route $route, \Phwoolcon\Router $router ): boolean
```






* **Inherits** \Phwoolcon\Router\FilterTrait::__invoke()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $uri | **string** | &nbsp; |
| $route | **\Phalcon\Mvc\Router\Route** | &nbsp; |
| $router | **\Phwoolcon\Router** | &nbsp; |




---

<a name="instance">&nbsp;</a>

### instance <kbd>static</kbd>
```php
DisableSessionFilter::instance(  )
```






* **Inherits** \Phwoolcon\Router\FilterTrait::instance()




---

<a name="phwoolcon-events">&nbsp;</a>

## Phwoolcon\Events
Class Events




**See Also:**

* \Phalcon\Events\Manager::detach() * \Phalcon\Events\Manager::detachAll() 

<a name="--callstatic-2">&nbsp;</a>

### __callStatic <kbd>static</kbd>
```php
Events::__callStatic(  $name,  $arguments )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $arguments | **mixed** | &nbsp; |




---

<a name="attach">&nbsp;</a>

### attach <kbd>static</kbd>
```php
Events::attach(  $eventType,  $handler,  $priority = 100 )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $eventType | **mixed** | &nbsp; |
| $handler | **mixed** | &nbsp; |
| $priority | **mixed** | &nbsp; |




---

<a name="detach">&nbsp;</a>

### detach <kbd>magic</kbd>
```php
Events::detach( string $eventType, object $handler ): void
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $eventType | **string** | &nbsp; |
| $handler | **object** | &nbsp; |




---

<a name="detachall">&nbsp;</a>

### detachAll <kbd>magic</kbd>
```php
Events::detachAll( string $type = null ): void
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $type | **string** | &nbsp; |




---

<a name="fire-2">&nbsp;</a>

### fire <kbd>static</kbd>
```php
Events::fire(  $eventType,  $source,  $data = null,  $cancelable = true )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $eventType | **mixed** | &nbsp; |
| $source | **mixed** | &nbsp; |
| $data | **mixed** | &nbsp; |
| $cancelable | **mixed** | &nbsp; |




---

<a name="register-8">&nbsp;</a>

### register <kbd>static</kbd>
```php
Events::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="phwoolcon-queue-failedloggerdb">&nbsp;</a>

## Phwoolcon\Queue\FailedLoggerDb






<a name="--construct-7">&nbsp;</a>

### __construct
```php
FailedLoggerDb::__construct(  $options )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **mixed** | &nbsp; |




---

<a name="log">&nbsp;</a>

### log
```php
FailedLoggerDb::log( string $connection, string $queue, string $payload ): void
```

Log a failed job into storage.





**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $connection | **string** | &nbsp; |
| $queue | **string** | &nbsp; |
| $payload | **string** | &nbsp; |




---

<a name="phwoolcon-exception-http-forbiddenexception">&nbsp;</a>

## Phwoolcon\Exception\Http\ForbiddenException




* Parent class: Phwoolcon\Exception\HttpException


<a name="--construct-8">&nbsp;</a>

### __construct
```php
ForbiddenException::__construct(  $message,  $headers = null )
```






* **Overrides** \Phwoolcon\Exception\HttpException::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $message | **mixed** | &nbsp; |
| $headers | **mixed** | &nbsp; |




---

<a name="getheaders">&nbsp;</a>

### getHeaders
```php
ForbiddenException::getHeaders(  )
```






* **Inherits** \Phwoolcon\Exception\HttpException::getHeaders()




---

<a name="toresponse">&nbsp;</a>

### toResponse
```php
ForbiddenException::toResponse(  )
```






* **Inherits** \Phwoolcon\Exception\HttpException::toResponse()




---

<a name="phwoolcon-exception-httpexception">&nbsp;</a>

## Phwoolcon\Exception\HttpException






<a name="--construct-5">&nbsp;</a>

### __construct
```php
HttpException::__construct(  $message,  $code,  $headers = null )
```






* **Inherits** \Phwoolcon\Exception\HttpException::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $message | **mixed** | &nbsp; |
| $code | **mixed** | &nbsp; |
| $headers | **mixed** | &nbsp; |




---

<a name="getheaders">&nbsp;</a>

### getHeaders
```php
HttpException::getHeaders(  )
```






* **Inherits** \Phwoolcon\Exception\HttpException::getHeaders()




---

<a name="toresponse">&nbsp;</a>

### toResponse
```php
HttpException::toResponse(  )
```






* **Inherits** \Phwoolcon\Exception\HttpException::toResponse()




---

<a name="phwoolcon-i18n">&nbsp;</a>

## Phwoolcon\I18n




* **Implements**: \Phwoolcon\Daemon\ServiceAwareInterface


<a name="--construct-9">&nbsp;</a>

### __construct
```php
I18n::__construct( array $options = array() )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **array** | &nbsp; |




---

<a name="checkmobile">&nbsp;</a>

### checkMobile <kbd>static</kbd>
```php
I18n::checkMobile(  $mobile,  $country = 'CN' )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $mobile | **mixed** | &nbsp; |
| $country | **mixed** | &nbsp; |




---

<a name="clearcache-1">&nbsp;</a>

### clearCache <kbd>static</kbd>
```php
I18n::clearCache(  $memoryOnly = false )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $memoryOnly | **mixed** | &nbsp; |




---

<a name="exists-1">&nbsp;</a>

### exists
```php
I18n::exists(  $index )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **mixed** | &nbsp; |




---

<a name="formatprice">&nbsp;</a>

### formatPrice <kbd>static</kbd>
```php
I18n::formatPrice(  $amount,  $currency = 'CNY' )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $amount | **mixed** | &nbsp; |
| $currency | **mixed** | &nbsp; |




---

<a name="getavailablelocales">&nbsp;</a>

### getAvailableLocales <kbd>static</kbd>
```php
I18n::getAvailableLocales(  )
```










---

<a name="getcurrentlocale">&nbsp;</a>

### getCurrentLocale <kbd>static</kbd>
```php
I18n::getCurrentLocale(  )
```










---

<a name="loadlocale">&nbsp;</a>

### loadLocale
```php
I18n::loadLocale(  $locale,  $force = false )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $locale | **mixed** | &nbsp; |
| $force | **mixed** | &nbsp; |




---

<a name="query">&nbsp;</a>

### query
```php
I18n::query(  $string,  $params = null,  $package = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $string | **mixed** | &nbsp; |
| $params | **mixed** | &nbsp; |
| $package | **mixed** | &nbsp; |




---

<a name="register-9">&nbsp;</a>

### register <kbd>static</kbd>
```php
I18n::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="reset-6">&nbsp;</a>

### reset
```php
I18n::reset(  )
```






* **Implements** \Phwoolcon\Daemon\ServiceAwareInterface::reset()




---

<a name="setlocale">&nbsp;</a>

### setLocale <kbd>static</kbd>
```php
I18n::setLocale(  $locale )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $locale | **mixed** | &nbsp; |




---

<a name="staticreset">&nbsp;</a>

### staticReset <kbd>static</kbd>
```php
I18n::staticReset(  )
```










---

<a name="translate">&nbsp;</a>

### translate <kbd>static</kbd>
```php
I18n::translate(  $string, array $params = null,  $package = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $string | **mixed** | &nbsp; |
| $params | **array** | &nbsp; |
| $package | **mixed** | &nbsp; |




---

<a name="usemultilocale">&nbsp;</a>

### useMultiLocale <kbd>static</kbd>
```php
I18n::useMultiLocale(  $flag = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $flag | **mixed** | &nbsp; |




---

<a name="phwoolcon-model-metadata-incache">&nbsp;</a>

## Phwoolcon\Model\MetaData\InCache
Phwoolcon\Model\MetaData\InCache

Stores model meta-data in cache.

<code>
$metaData = new \Phwoolcon\Model\Metadata\InCache();
</code>



<a name="getnonprimarykeyattributes">&nbsp;</a>

### getNonPrimaryKeyAttributes
```php
InCache::getNonPrimaryKeyAttributes( \Phalcon\Mvc\ModelInterface $model )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $model | **\Phalcon\Mvc\ModelInterface** | &nbsp; |




---

<a name="read">&nbsp;</a>

### read
```php
InCache::read( string $key ): mixed
```

Reads meta-data from files





**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **string** | &nbsp; |




---

<a name="reset-7">&nbsp;</a>

### reset
```php
InCache::reset(  )
```










---

<a name="write">&nbsp;</a>

### write
```php
InCache::write( string $key, array $data )
```

Writes the meta-data to files





**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **string** | &nbsp; |
| $data | **array** | &nbsp; |




---

<a name="phwoolcon-queue-adapter-beanstalkd-job">&nbsp;</a>

## Phwoolcon\Queue\Adapter\Beanstalkd\Job
Class Job



* **Implements**: \Phwoolcon\Queue\Adapter\JobInterface


<a name="--construct-10">&nbsp;</a>

### __construct
```php
Job::__construct( \Phwoolcon\Queue\AdapterInterface|\Phwoolcon\Queue\AdapterTrait $queue,  $rawJob, string $queueName )
```

JobTrait constructor.




* **Inherits** \Phwoolcon\Queue\Adapter\JobTrait::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $queue | **\Phwoolcon\Queue\AdapterInterface&#124;\Phwoolcon\Queue\AdapterTrait** | &nbsp; |
| $rawJob | **mixed** | &nbsp; |
| $queueName | **string** | &nbsp; |




---

<a name="attempts">&nbsp;</a>

### attempts
```php
Job::attempts(  ): integer
```

Get the number of times the job has been attempted.




* **Implements** \Phwoolcon\Queue\Adapter\JobInterface::attempts()




---

<a name="bury">&nbsp;</a>

### bury
```php
Job::bury(  ): void
```

Bury the job in the queue.








---

<a name="delete-3">&nbsp;</a>

### delete
```php
Job::delete(  )
```






* **Inherits** \Phwoolcon\Queue\Adapter\JobTrait::delete()




---

<a name="fire-3">&nbsp;</a>

### fire
```php
Job::fire(  )
```






* **Inherits** \Phwoolcon\Queue\Adapter\JobTrait::fire()




---

<a name="getjobid">&nbsp;</a>

### getJobId
```php
Job::getJobId(  ): string
```

Get the job identifier.








---

<a name="getname">&nbsp;</a>

### getName
```php
Job::getName(  )
```






* **Inherits** \Phwoolcon\Queue\Adapter\JobTrait::getName()




---

<a name="getqueue-1">&nbsp;</a>

### getQueue
```php
Job::getQueue(  ): \Phwoolcon\Queue\AdapterInterface|\Phwoolcon\Queue\AdapterTrait
```






* **Inherits** \Phwoolcon\Queue\Adapter\JobTrait::getQueue()




---

<a name="getqueuename">&nbsp;</a>

### getQueueName
```php
Job::getQueueName(  ): string
```






* **Inherits** \Phwoolcon\Queue\Adapter\JobTrait::getQueueName()




---

<a name="getrawbody">&nbsp;</a>

### getRawBody
```php
Job::getRawBody(  )
```






* **Overrides** \Phwoolcon\Queue\Adapter\JobTrait::getRawBody()




---

<a name="getrawjob">&nbsp;</a>

### getRawJob <kbd>magic</kbd>
```php
Job::getRawJob(  ): \Pheanstalk\Job
```






* **Inherits** \Phwoolcon\Queue\Adapter\JobTrait::getRawJob()




---

<a name="isdeleted">&nbsp;</a>

### isDeleted
```php
Job::isDeleted(  ): boolean
```

Determine if the job has been deleted.




* **Inherits** \Phwoolcon\Queue\Adapter\JobTrait::isDeleted()




---

<a name="release">&nbsp;</a>

### release
```php
Job::release(  $delay )
```






* **Inherits** \Phwoolcon\Queue\Adapter\JobTrait::release()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $delay | **mixed** | &nbsp; |




---

<a name="phwoolcon-assets-resource-js">&nbsp;</a>

## Phwoolcon\Assets\Resource\Js






<a name="concatenatehash">&nbsp;</a>

### concatenateHash
```php
Js::concatenateHash(  $previousHash )
```






* **Inherits** \Phwoolcon\Assets\ResourceTrait::concatenateHash()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $previousHash | **mixed** | &nbsp; |




---

<a name="getcontent">&nbsp;</a>

### getContent
```php
Js::getContent(  $basePath = null )
```






* **Inherits** \Phwoolcon\Assets\ResourceTrait::getContent()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $basePath | **mixed** | &nbsp; |




---

<a name="setbasepath">&nbsp;</a>

### setBasePath <kbd>static</kbd>
```php
Js::setBasePath(  $path )
```






* **Inherits** \Phwoolcon\Assets\ResourceTrait::setBasePath()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **mixed** | &nbsp; |




---

<a name="setrunningunittests">&nbsp;</a>

### setRunningUnitTests <kbd>static</kbd>
```php
Js::setRunningUnitTests(  $flag )
```






* **Inherits** \Phwoolcon\Assets\ResourceTrait::setRunningUnitTests()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $flag | **mixed** | &nbsp; |




---

<a name="phwoolcon-queue-listener">&nbsp;</a>

## Phwoolcon\Queue\Listener






<a name="pop-1">&nbsp;</a>

### pop
```php
Listener::pop( string $connectionName, string $queue = null, integer $delay, integer $sleep = 3, integer $maxTries ): array
```

Listen to the given queue.





**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $connectionName | **string** | &nbsp; |
| $queue | **string** | &nbsp; |
| $delay | **integer** | &nbsp; |
| $sleep | **integer** | &nbsp; |
| $maxTries | **integer** | &nbsp; |




---

<a name="process">&nbsp;</a>

### process
```php
Listener::process( \Phwoolcon\Queue\Adapter\JobInterface|\Phwoolcon\Queue\Adapter\JobTrait $job, integer $maxTries, integer $delay ): array|null
```

Process a given job from the queue.





**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $job | **\Phwoolcon\Queue\Adapter\JobInterface&#124;\Phwoolcon\Queue\Adapter\JobTrait** | &nbsp; |
| $maxTries | **integer** | &nbsp; |
| $delay | **integer** | &nbsp; |




---

<a name="phwoolcon-model-dynamictrait-loader">&nbsp;</a>

## Phwoolcon\Model\DynamicTrait\Loader






<a name="autoload">&nbsp;</a>

### autoLoad
```php
Loader::autoLoad(  $className )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $className | **mixed** | &nbsp; |




---

<a name="register-10">&nbsp;</a>

### register <kbd>static</kbd>
```php
Loader::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="phwoolcon-log">&nbsp;</a>

## Phwoolcon\Log






<a name="debug">&nbsp;</a>

### debug <kbd>static</kbd>
```php
Log::debug(  $message = null, array $context = array() )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $message | **mixed** | &nbsp; |
| $context | **array** | &nbsp; |




---

<a name="error-1">&nbsp;</a>

### error <kbd>static</kbd>
```php
Log::error(  $message = null, array $context = array() )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $message | **mixed** | &nbsp; |
| $context | **array** | &nbsp; |




---

<a name="exception">&nbsp;</a>

### exception <kbd>static</kbd>
```php
Log::exception( \Exception $e )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $e | **\Exception** | &nbsp; |




---

<a name="info-1">&nbsp;</a>

### info <kbd>static</kbd>
```php
Log::info(  $message = null, array $context = array() )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $message | **mixed** | &nbsp; |
| $context | **array** | &nbsp; |




---

<a name="log-1">&nbsp;</a>

### log <kbd>static</kbd>
```php
Log::log(  $type,  $message = null, array $context = array() )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $type | **mixed** | &nbsp; |
| $message | **mixed** | &nbsp; |
| $context | **array** | &nbsp; |




---

<a name="register-11">&nbsp;</a>

### register <kbd>static</kbd>
```php
Log::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="warning">&nbsp;</a>

### warning <kbd>static</kbd>
```php
Log::warning(  $message = null, array $context = array() )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $message | **mixed** | &nbsp; |
| $context | **array** | &nbsp; |




---

<a name="phwoolcon-session-adapter-memcached">&nbsp;</a>

## Phwoolcon\Session\Adapter\Memcached
Class Memcached



* **Implements**: \Phwoolcon\Session\AdapterInterface


<a name="--construct-11">&nbsp;</a>

### __construct
```php
Memcached::__construct( array $options = array() )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **array** | &nbsp; |




---

<a name="clear">&nbsp;</a>

### clear
```php
Memcached::clear(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::clear()




---

<a name="clearformdata">&nbsp;</a>

### clearFormData
```php
Memcached::clearFormData(  $key )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::clearFormData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="end">&nbsp;</a>

### end
```php
Memcached::end(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::end()




---

<a name="flush-1">&nbsp;</a>

### flush
```php
Memcached::flush(  )
```






* **Overrides** \Phwoolcon\Session\AdapterTrait::flush()




---

<a name="generatecsrftoken">&nbsp;</a>

### generateCsrfToken
```php
Memcached::generateCsrfToken(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::generateCsrfToken()




---

<a name="get-3">&nbsp;</a>

### get
```php
Memcached::get(  $index,  $defaultValue = null,  $remove = false )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::get()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **mixed** | &nbsp; |
| $defaultValue | **mixed** | &nbsp; |
| $remove | **mixed** | &nbsp; |




---

<a name="getcsrftoken">&nbsp;</a>

### getCsrfToken
```php
Memcached::getCsrfToken(  $renew = false )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::getCsrfToken()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $renew | **mixed** | &nbsp; |




---

<a name="getformdata">&nbsp;</a>

### getFormData
```php
Memcached::getFormData(  $key,  $default = null )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::getFormData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="getlibmemcached">&nbsp;</a>

### getLibmemcached <kbd>magic</kbd>
```php
Memcached::getLibmemcached(  ): \Phalcon\Cache\Backend\Libmemcached
```










---

<a name="readcookieandstart">&nbsp;</a>

### readCookieAndStart
```php
Memcached::readCookieAndStart(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::readCookieAndStart()




---

<a name="regenerateid">&nbsp;</a>

### regenerateId
```php
Memcached::regenerateId(  $deleteOldSession = true )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::regenerateId()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $deleteOldSession | **mixed** | &nbsp; |




---

<a name="rememberformdata">&nbsp;</a>

### rememberFormData
```php
Memcached::rememberFormData(  $key,  $data )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::rememberFormData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $data | **mixed** | &nbsp; |




---

<a name="remove">&nbsp;</a>

### remove
```php
Memcached::remove(  $index )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::remove()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **mixed** | &nbsp; |




---

<a name="set-3">&nbsp;</a>

### set
```php
Memcached::set(  $index,  $value )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::set()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setcookie">&nbsp;</a>

### setCookie
```php
Memcached::setCookie(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::setCookie()




---

<a name="start">&nbsp;</a>

### start
```php
Memcached::start(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::start()




---

<a name="phwoolcon-cli-command-migrate">&nbsp;</a>

## Phwoolcon\Cli\Command\Migrate




* Parent class: Phwoolcon\Cli\Command


<a name="--construct-4">&nbsp;</a>

### __construct
```php
Migrate::__construct(  $name, \Phalcon\Di $di )
```






* **Inherits** \Phwoolcon\Cli\Command::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="ask">&nbsp;</a>

### ask
```php
Migrate::ask(  $question,  $default = null )
```






* **Inherits** \Phwoolcon\Cli\Command::ask()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="cleanmigrationstable">&nbsp;</a>

### cleanMigrationsTable
```php
Migrate::cleanMigrationsTable(  )
```






* **Inherits** \Phwoolcon\Cli\Command\Migrate::cleanMigrationsTable()




---

<a name="clearmigratedcache">&nbsp;</a>

### clearMigratedCache
```php
Migrate::clearMigratedCache(  )
```






* **Inherits** \Phwoolcon\Cli\Command\Migrate::clearMigratedCache()




---

<a name="comment">&nbsp;</a>

### comment
```php
Migrate::comment(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::comment()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="confirm">&nbsp;</a>

### confirm
```php
Migrate::confirm(  $question,  $default = true )
```






* **Inherits** \Phwoolcon\Cli\Command::confirm()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="createprogressbar">&nbsp;</a>

### createProgressBar
```php
Migrate::createProgressBar(  $max )
```






* **Inherits** \Phwoolcon\Cli\Command::createProgressBar()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $max | **mixed** | &nbsp; |




---

<a name="error">&nbsp;</a>

### error
```php
Migrate::error(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::error()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="execute-1">&nbsp;</a>

### execute
```php
Migrate::execute( \Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output )
```






* **Overrides** \Phwoolcon\Cli\Command::execute()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $input | **\Symfony\Component\Console\Input\InputInterface** | &nbsp; |
| $output | **\Symfony\Component\Console\Output\OutputInterface** | &nbsp; |




---

<a name="fire-4">&nbsp;</a>

### fire
```php
Migrate::fire(  )
```






* **Overrides** \Phwoolcon\Cli\Command::fire()




---

<a name="getdefaulttablecharset-1">&nbsp;</a>

### getDefaultTableCharset
```php
Migrate::getDefaultTableCharset(  )
```






* **Inherits** \Phwoolcon\Cli\Command\Migrate::getDefaultTableCharset()




---

<a name="getdi-1">&nbsp;</a>

### getDi
```php
Migrate::getDi(  ): \Phalcon\Di
```






* **Inherits** \Phwoolcon\Cli\Command::getDi()




---

<a name="info">&nbsp;</a>

### info
```php
Migrate::info(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::info()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="question">&nbsp;</a>

### question
```php
Migrate::question(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::question()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="setdi">&nbsp;</a>

### setDi
```php
Migrate::setDi( \Phalcon\Di $di ): $this
```






* **Inherits** \Phwoolcon\Cli\Command::setDi()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="phwoolcon-cli-command-migratecreate">&nbsp;</a>

## Phwoolcon\Cli\Command\MigrateCreate




* Parent class: Phwoolcon\Cli\Command


<a name="--construct-4">&nbsp;</a>

### __construct
```php
MigrateCreate::__construct(  $name, \Phalcon\Di $di )
```






* **Inherits** \Phwoolcon\Cli\Command::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="ask">&nbsp;</a>

### ask
```php
MigrateCreate::ask(  $question,  $default = null )
```






* **Inherits** \Phwoolcon\Cli\Command::ask()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="comment">&nbsp;</a>

### comment
```php
MigrateCreate::comment(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::comment()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="confirm">&nbsp;</a>

### confirm
```php
MigrateCreate::confirm(  $question,  $default = true )
```






* **Inherits** \Phwoolcon\Cli\Command::confirm()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="createprogressbar">&nbsp;</a>

### createProgressBar
```php
MigrateCreate::createProgressBar(  $max )
```






* **Inherits** \Phwoolcon\Cli\Command::createProgressBar()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $max | **mixed** | &nbsp; |




---

<a name="error">&nbsp;</a>

### error
```php
MigrateCreate::error(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::error()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="execute">&nbsp;</a>

### execute
```php
MigrateCreate::execute( \Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output )
```






* **Inherits** \Phwoolcon\Cli\Command::execute()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $input | **\Symfony\Component\Console\Input\InputInterface** | &nbsp; |
| $output | **\Symfony\Component\Console\Output\OutputInterface** | &nbsp; |




---

<a name="fire-5">&nbsp;</a>

### fire
```php
MigrateCreate::fire(  )
```






* **Overrides** \Phwoolcon\Cli\Command::fire()




---

<a name="getdi-1">&nbsp;</a>

### getDi
```php
MigrateCreate::getDi(  ): \Phalcon\Di
```






* **Inherits** \Phwoolcon\Cli\Command::getDi()




---

<a name="info">&nbsp;</a>

### info
```php
MigrateCreate::info(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::info()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="question">&nbsp;</a>

### question
```php
MigrateCreate::question(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::question()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="setdi">&nbsp;</a>

### setDi
```php
MigrateCreate::setDi( \Phalcon\Di $di ): $this
```






* **Inherits** \Phwoolcon\Cli\Command::setDi()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="template">&nbsp;</a>

### template
```php
MigrateCreate::template(  )
```










---

<a name="phwoolcon-cli-command-migratelist">&nbsp;</a>

## Phwoolcon\Cli\Command\MigrateList




* Parent class: Phwoolcon\Cli\Command\Migrate


<a name="--construct-4">&nbsp;</a>

### __construct
```php
MigrateList::__construct(  $name, \Phalcon\Di $di )
```






* **Inherits** \Phwoolcon\Cli\Command::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="ask">&nbsp;</a>

### ask
```php
MigrateList::ask(  $question,  $default = null )
```






* **Inherits** \Phwoolcon\Cli\Command::ask()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="cleanmigrationstable">&nbsp;</a>

### cleanMigrationsTable
```php
MigrateList::cleanMigrationsTable(  )
```






* **Inherits** \Phwoolcon\Cli\Command\Migrate::cleanMigrationsTable()




---

<a name="clearmigratedcache">&nbsp;</a>

### clearMigratedCache
```php
MigrateList::clearMigratedCache(  )
```






* **Inherits** \Phwoolcon\Cli\Command\Migrate::clearMigratedCache()




---

<a name="comment">&nbsp;</a>

### comment
```php
MigrateList::comment(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::comment()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="confirm">&nbsp;</a>

### confirm
```php
MigrateList::confirm(  $question,  $default = true )
```






* **Inherits** \Phwoolcon\Cli\Command::confirm()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="createprogressbar">&nbsp;</a>

### createProgressBar
```php
MigrateList::createProgressBar(  $max )
```






* **Inherits** \Phwoolcon\Cli\Command::createProgressBar()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $max | **mixed** | &nbsp; |




---

<a name="error">&nbsp;</a>

### error
```php
MigrateList::error(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::error()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="execute">&nbsp;</a>

### execute
```php
MigrateList::execute( \Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output )
```






* **Inherits** \Phwoolcon\Cli\Command::execute()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $input | **\Symfony\Component\Console\Input\InputInterface** | &nbsp; |
| $output | **\Symfony\Component\Console\Output\OutputInterface** | &nbsp; |




---

<a name="fire-6">&nbsp;</a>

### fire
```php
MigrateList::fire(  )
```






* **Overrides** \Phwoolcon\Cli\Command::fire()




---

<a name="getdefaulttablecharset-1">&nbsp;</a>

### getDefaultTableCharset
```php
MigrateList::getDefaultTableCharset(  )
```






* **Inherits** \Phwoolcon\Cli\Command\Migrate::getDefaultTableCharset()




---

<a name="getdi-1">&nbsp;</a>

### getDi
```php
MigrateList::getDi(  ): \Phalcon\Di
```






* **Inherits** \Phwoolcon\Cli\Command::getDi()




---

<a name="info">&nbsp;</a>

### info
```php
MigrateList::info(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::info()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="question">&nbsp;</a>

### question
```php
MigrateList::question(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::question()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="setdi">&nbsp;</a>

### setDi
```php
MigrateList::setDi( \Phalcon\Di $di ): $this
```






* **Inherits** \Phwoolcon\Cli\Command::setDi()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="phwoolcon-cli-command-migraterevert">&nbsp;</a>

## Phwoolcon\Cli\Command\MigrateRevert




* Parent class: Phwoolcon\Cli\Command\Migrate


<a name="--construct-4">&nbsp;</a>

### __construct
```php
MigrateRevert::__construct(  $name, \Phalcon\Di $di )
```






* **Inherits** \Phwoolcon\Cli\Command::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="ask">&nbsp;</a>

### ask
```php
MigrateRevert::ask(  $question,  $default = null )
```






* **Inherits** \Phwoolcon\Cli\Command::ask()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="cleanmigrationstable">&nbsp;</a>

### cleanMigrationsTable
```php
MigrateRevert::cleanMigrationsTable(  )
```






* **Inherits** \Phwoolcon\Cli\Command\Migrate::cleanMigrationsTable()




---

<a name="clearmigratedcache">&nbsp;</a>

### clearMigratedCache
```php
MigrateRevert::clearMigratedCache(  )
```






* **Inherits** \Phwoolcon\Cli\Command\Migrate::clearMigratedCache()




---

<a name="comment">&nbsp;</a>

### comment
```php
MigrateRevert::comment(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::comment()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="confirm">&nbsp;</a>

### confirm
```php
MigrateRevert::confirm(  $question,  $default = true )
```






* **Inherits** \Phwoolcon\Cli\Command::confirm()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="createprogressbar">&nbsp;</a>

### createProgressBar
```php
MigrateRevert::createProgressBar(  $max )
```






* **Inherits** \Phwoolcon\Cli\Command::createProgressBar()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $max | **mixed** | &nbsp; |




---

<a name="error">&nbsp;</a>

### error
```php
MigrateRevert::error(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::error()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="execute">&nbsp;</a>

### execute
```php
MigrateRevert::execute( \Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output )
```






* **Inherits** \Phwoolcon\Cli\Command::execute()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $input | **\Symfony\Component\Console\Input\InputInterface** | &nbsp; |
| $output | **\Symfony\Component\Console\Output\OutputInterface** | &nbsp; |




---

<a name="fire-7">&nbsp;</a>

### fire
```php
MigrateRevert::fire(  )
```






* **Overrides** \Phwoolcon\Cli\Command::fire()




---

<a name="getdefaulttablecharset-1">&nbsp;</a>

### getDefaultTableCharset
```php
MigrateRevert::getDefaultTableCharset(  )
```






* **Inherits** \Phwoolcon\Cli\Command\Migrate::getDefaultTableCharset()




---

<a name="getdi-1">&nbsp;</a>

### getDi
```php
MigrateRevert::getDi(  ): \Phalcon\Di
```






* **Inherits** \Phwoolcon\Cli\Command::getDi()




---

<a name="info">&nbsp;</a>

### info
```php
MigrateRevert::info(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::info()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="question">&nbsp;</a>

### question
```php
MigrateRevert::question(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::question()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="setdi">&nbsp;</a>

### setDi
```php
MigrateRevert::setDi( \Phalcon\Di $di ): $this
```






* **Inherits** \Phwoolcon\Cli\Command::setDi()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="phwoolcon-model">&nbsp;</a>

## Phwoolcon\Model <kbd>abstract</kbd>
Class Model





<a name="--call">&nbsp;</a>

### __call
```php
Model::__call(  $method,  $arguments )
```






* **Inherits** \Phwoolcon\Model::__call()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $method | **mixed** | &nbsp; |
| $arguments | **mixed** | &nbsp; |




---

<a name="adddata">&nbsp;</a>

### addData
```php
Model::addData( array $data )
```






* **Inherits** \Phwoolcon\Model::addData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $data | **array** | &nbsp; |




---

<a name="afterfetch">&nbsp;</a>

### afterFetch
```php
Model::afterFetch(  )
```






* **Inherits** \Phwoolcon\Model::afterFetch()




---

<a name="buildparams">&nbsp;</a>

### buildParams <kbd>static</kbd>
```php
Model::buildParams(  $conditions = array(), array $bind = array(), string $orderBy = null, string $columns = null, string|integer $limit = null ): array
```






* **Inherits** \Phwoolcon\Model::buildParams()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **mixed** | &nbsp; |
| $bind | **array** | &nbsp; |
| $orderBy | **string** | &nbsp; |
| $columns | **string** | &nbsp; |
| $limit | **string&#124;integer** | &nbsp; |




---

<a name="checkdatacolumn">&nbsp;</a>

### checkDataColumn
```php
Model::checkDataColumn(  $column = null )
```






* **Inherits** \Phwoolcon\Model::checkDataColumn()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $column | **mixed** | &nbsp; |




---

<a name="cleardata">&nbsp;</a>

### clearData
```php
Model::clearData(  )
```






* **Inherits** \Phwoolcon\Model::clearData()




---

<a name="countsimple">&nbsp;</a>

### countSimple <kbd>static</kbd>
```php
Model::countSimple( array $conditions = array(), array $bind = array() ): mixed
```






* **Inherits** \Phwoolcon\Model::countSimple()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **array** | &nbsp; |
| $bind | **array** | &nbsp; |




---

<a name="findfirstsimple">&nbsp;</a>

### findFirstSimple <kbd>static</kbd>
```php
Model::findFirstSimple( array|string $conditions, array $bind = array(), string $order = null, string $columns = null ): $this|false
```






* **Inherits** \Phwoolcon\Model::findFirstSimple()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **array&#124;string** | &nbsp; |
| $bind | **array** | &nbsp; |
| $order | **string** | &nbsp; |
| $columns | **string** | &nbsp; |




---

<a name="findsimple">&nbsp;</a>

### findSimple <kbd>static</kbd>
```php
Model::findSimple(  $conditions = array(), array $bind = array(), string $order = null, string $columns = null, string|integer $limit = null ): \Phalcon\Mvc\Model\Resultset\Simple|\Phalcon\Mvc\Model\ResultsetInterface
```






* **Inherits** \Phwoolcon\Model::findSimple()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **mixed** | &nbsp; |
| $bind | **array** | &nbsp; |
| $order | **string** | &nbsp; |
| $columns | **string** | &nbsp; |
| $limit | **string&#124;integer** | &nbsp; |




---

<a name="generatedistributedid">&nbsp;</a>

### generateDistributedId
```php
Model::generateDistributedId(  )
```






* **Inherits** \Phwoolcon\Model::generateDistributedId()




---

<a name="getadditionaldata">&nbsp;</a>

### getAdditionalData
```php
Model::getAdditionalData(  $key = null )
```






* **Inherits** \Phwoolcon\Model::getAdditionalData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="getdata">&nbsp;</a>

### getData
```php
Model::getData(  $key = null )
```






* **Inherits** \Phwoolcon\Model::getData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="getid">&nbsp;</a>

### getId
```php
Model::getId(  )
```






* **Inherits** \Phwoolcon\Model::getId()




---

<a name="getinjectedclass">&nbsp;</a>

### getInjectedClass
```php
Model::getInjectedClass(  $class )
```






* **Inherits** \Phwoolcon\Model::getInjectedClass()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $class | **mixed** | &nbsp; |




---

<a name="getmessages-1">&nbsp;</a>

### getMessages <kbd>magic</kbd>
```php
Model::getMessages( string $filter = null ): array<mixed,\Phalcon\Mvc\Model\Message>
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $filter | **string** | &nbsp; |




---

<a name="getstringmessages">&nbsp;</a>

### getStringMessages
```php
Model::getStringMessages(  )
```






* **Inherits** \Phwoolcon\Model::getStringMessages()




---

<a name="getwriteconnection-1">&nbsp;</a>

### getWriteConnection <kbd>magic</kbd>
```php
Model::getWriteConnection(  ): \Phwoolcon\Db\Adapter\Pdo\Mysql|\Phalcon\Db\Adapter\Pdo
```










---

<a name="initialize">&nbsp;</a>

### initialize
```php
Model::initialize(  )
```

Runs once, only when the model instance is created at the first time




* **Inherits** \Phwoolcon\Model::initialize()




---

<a name="isnew">&nbsp;</a>

### isNew
```php
Model::isNew(  )
```






* **Inherits** \Phwoolcon\Model::isNew()




---

<a name="reset-2">&nbsp;</a>

### reset
```php
Model::reset(  )
```






* **Inherits** \Phwoolcon\Model::reset()




---

<a name="setdata">&nbsp;</a>

### setData
```php
Model::setData(  $key,  $value = null )
```






* **Inherits** \Phwoolcon\Model::setData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setid">&nbsp;</a>

### setId
```php
Model::setId(  $id )
```






* **Inherits** \Phwoolcon\Model::setId()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $id | **mixed** | &nbsp; |




---

<a name="setrelatedrecord">&nbsp;</a>

### setRelatedRecord
```php
Model::setRelatedRecord(  $key,  $value )
```






* **Inherits** \Phwoolcon\Model::setRelatedRecord()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setup">&nbsp;</a>

### setup <kbd>static</kbd>
```php
Model::setup( array $options )
```






* **Inherits** \Phwoolcon\Model::setup()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **array** | &nbsp; |




---

<a name="sqlexecute">&nbsp;</a>

### sqlExecute
```php
Model::sqlExecute(  $sql, null $bind = null ): boolean
```






* **Inherits** \Phwoolcon\Model::sqlExecute()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="sqlfetchall">&nbsp;</a>

### sqlFetchAll
```php
Model::sqlFetchAll(  $sql, null $bind = null ): array
```






* **Inherits** \Phwoolcon\Model::sqlFetchAll()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="sqlfetchcolumn">&nbsp;</a>

### sqlFetchColumn
```php
Model::sqlFetchColumn(  $sql, null $bind = null ): mixed
```






* **Inherits** \Phwoolcon\Model::sqlFetchColumn()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="sqlfetchone">&nbsp;</a>

### sqlFetchOne
```php
Model::sqlFetchOne(  $sql, null $bind = null ): array
```






* **Inherits** \Phwoolcon\Model::sqlFetchOne()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="validation">&nbsp;</a>

### validation
```php
Model::validation(  )
```






* **Inherits** \Phwoolcon\Model::validation()




---

<a name="phwoolcon-router-filter-multifilter">&nbsp;</a>

## Phwoolcon\Router\Filter\MultiFilter




* **Implements**: \Phwoolcon\Router\FilterInterface


<a name="--invoke-1">&nbsp;</a>

### __invoke
```php
MultiFilter::__invoke( string $uri, \Phalcon\Mvc\Router\Route $route, \Phwoolcon\Router $router ): boolean
```






* **Implements** \Phwoolcon\Router\FilterInterface::__invoke()
* **Overrides** \Phwoolcon\Router\FilterTrait::__invoke()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $uri | **string** | &nbsp; |
| $route | **\Phalcon\Mvc\Router\Route** | &nbsp; |
| $router | **\Phwoolcon\Router** | &nbsp; |




---

<a name="add">&nbsp;</a>

### add
```php
MultiFilter::add( \Phwoolcon\Router\FilterInterface $filter )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $filter | **\Phwoolcon\Router\FilterInterface** | &nbsp; |




---

<a name="instance-1">&nbsp;</a>

### instance <kbd>static</kbd>
```php
MultiFilter::instance(  )
```






* **Overrides** \Phwoolcon\Router\FilterTrait::instance()




---

<a name="remove-1">&nbsp;</a>

### remove
```php
MultiFilter::remove( string $key ): $this
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **string** | &nbsp; |




---

<a name="phwoolcon-db-adapter-pdo-mysql">&nbsp;</a>

## Phwoolcon\Db\Adapter\Pdo\Mysql






<a name="phwoolcon-session-adapter-native">&nbsp;</a>

## Phwoolcon\Session\Adapter\Native




* **Implements**: \Phwoolcon\Session\AdapterInterface


<a name="--construct-12">&nbsp;</a>

### __construct
```php
Native::__construct(  $options = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **mixed** | &nbsp; |




---

<a name="clear">&nbsp;</a>

### clear
```php
Native::clear(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::clear()




---

<a name="clearformdata">&nbsp;</a>

### clearFormData
```php
Native::clearFormData(  $key )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::clearFormData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="end">&nbsp;</a>

### end
```php
Native::end(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::end()




---

<a name="flush-2">&nbsp;</a>

### flush
```php
Native::flush(  )
```






* **Overrides** \Phwoolcon\Session\AdapterTrait::flush()




---

<a name="generatecsrftoken">&nbsp;</a>

### generateCsrfToken
```php
Native::generateCsrfToken(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::generateCsrfToken()




---

<a name="get-3">&nbsp;</a>

### get
```php
Native::get(  $index,  $defaultValue = null,  $remove = false )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::get()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **mixed** | &nbsp; |
| $defaultValue | **mixed** | &nbsp; |
| $remove | **mixed** | &nbsp; |




---

<a name="getcsrftoken">&nbsp;</a>

### getCsrfToken
```php
Native::getCsrfToken(  $renew = false )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::getCsrfToken()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $renew | **mixed** | &nbsp; |




---

<a name="getformdata">&nbsp;</a>

### getFormData
```php
Native::getFormData(  $key,  $default = null )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::getFormData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="readcookieandstart">&nbsp;</a>

### readCookieAndStart
```php
Native::readCookieAndStart(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::readCookieAndStart()




---

<a name="regenerateid">&nbsp;</a>

### regenerateId
```php
Native::regenerateId(  $deleteOldSession = true )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::regenerateId()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $deleteOldSession | **mixed** | &nbsp; |




---

<a name="rememberformdata">&nbsp;</a>

### rememberFormData
```php
Native::rememberFormData(  $key,  $data )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::rememberFormData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $data | **mixed** | &nbsp; |




---

<a name="remove">&nbsp;</a>

### remove
```php
Native::remove(  $index )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::remove()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **mixed** | &nbsp; |




---

<a name="set-3">&nbsp;</a>

### set
```php
Native::set(  $index,  $value )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::set()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setcookie">&nbsp;</a>

### setCookie
```php
Native::setCookie(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::setCookie()




---

<a name="start">&nbsp;</a>

### start
```php
Native::start(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::start()




---

<a name="phwoolcon-exception-http-notfoundexception">&nbsp;</a>

## Phwoolcon\Exception\Http\NotFoundException




* Parent class: Phwoolcon\Exception\HttpException


<a name="--construct-13">&nbsp;</a>

### __construct
```php
NotFoundException::__construct(  $message,  $headers = null )
```






* **Overrides** \Phwoolcon\Exception\HttpException::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $message | **mixed** | &nbsp; |
| $headers | **mixed** | &nbsp; |




---

<a name="getheaders">&nbsp;</a>

### getHeaders
```php
NotFoundException::getHeaders(  )
```






* **Inherits** \Phwoolcon\Exception\HttpException::getHeaders()




---

<a name="toresponse">&nbsp;</a>

### toResponse
```php
NotFoundException::toResponse(  )
```






* **Inherits** \Phwoolcon\Exception\HttpException::toResponse()




---

<a name="phwoolcon-util-reflection-stringify-parameter">&nbsp;</a>

## Phwoolcon\Util\Reflection\Stringify\Parameter






<a name="cast">&nbsp;</a>

### cast <kbd>static</kbd>
```php
Parameter::cast( \ReflectionParameter $parameter )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $parameter | **\ReflectionParameter** | &nbsp; |




---

<a name="phwoolcon-payload">&nbsp;</a>

## Phwoolcon\Payload






<a name="--call-1">&nbsp;</a>

### __call
```php
Payload::__call(  $method,  $arguments )
```






* **Inherits** \Phwoolcon\PayloadTrait::__call()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $method | **mixed** | &nbsp; |
| $arguments | **mixed** | &nbsp; |




---

<a name="--construct-14">&nbsp;</a>

### __construct
```php
Payload::__construct( array $data )
```






* **Inherits** \Phwoolcon\PayloadTrait::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $data | **array** | &nbsp; |




---

<a name="create">&nbsp;</a>

### create <kbd>static</kbd>
```php
Payload::create( array $data )
```






* **Inherits** \Phwoolcon\PayloadTrait::create()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $data | **array** | &nbsp; |




---

<a name="getdata-1">&nbsp;</a>

### getData
```php
Payload::getData(  $key = null,  $default = null )
```






* **Inherits** \Phwoolcon\PayloadTrait::getData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="hasdata">&nbsp;</a>

### hasData
```php
Payload::hasData(  $key )
```






* **Inherits** \Phwoolcon\PayloadTrait::hasData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="setdata-1">&nbsp;</a>

### setData
```php
Payload::setData(  $key,  $value = null )
```






* **Inherits** \Phwoolcon\PayloadTrait::setData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="phwoolcon-view-engine-php">&nbsp;</a>

## Phwoolcon\View\Engine\Php
Class Php





<a name="--call-2">&nbsp;</a>

### __call
```php
Php::__call(  $name,  $params )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $params | **mixed** | &nbsp; |




---

<a name="--construct-15">&nbsp;</a>

### __construct
```php
Php::__construct( \Phwoolcon\View $view, \Phalcon\Di $di )
```

Php constructor.





**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $view | **\Phwoolcon\View** | &nbsp; |
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="include">&nbsp;</a>

### include <kbd>magic</kbd>
```php
Php::include( string $path, mixed $params = [] ): void
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **string** | &nbsp; |
| $params | **mixed** | &nbsp; |




---

<a name="processinclude">&nbsp;</a>

### processInclude
```php
Php::processInclude(  $path,  $params = array() )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **mixed** | &nbsp; |
| $params | **mixed** | &nbsp; |




---

<a name="phwoolcon-queue">&nbsp;</a>

## Phwoolcon\Queue






<a name="--construct-16">&nbsp;</a>

### __construct
```php
Queue::__construct(  $config )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $config | **mixed** | &nbsp; |




---

<a name="connection-1">&nbsp;</a>

### connection <kbd>static</kbd>
```php
Queue::connection(  $name = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |




---

<a name="getfaillogger">&nbsp;</a>

### getFailLogger <kbd>static</kbd>
```php
Queue::getFailLogger(  ): \Phwoolcon\Queue\FailedLoggerDb
```










---

<a name="register-12">&nbsp;</a>

### register <kbd>static</kbd>
```php
Queue::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="phwoolcon-exception-queueexception">&nbsp;</a>

## Phwoolcon\Exception\QueueException






<a name="phwoolcon-util-counter-adapter-rds">&nbsp;</a>

## Phwoolcon\Util\Counter\Adapter\Rds




* Parent class: Phwoolcon\Util\Counter\Adapter


<a name="--construct-17">&nbsp;</a>

### __construct
```php
Rds::__construct(  $options )
```






* **Overrides** \Phwoolcon\Util\Counter\Adapter::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **mixed** | &nbsp; |




---

<a name="decrement-4">&nbsp;</a>

### decrement
```php
Rds::decrement(  $keyName,  $value = 1 )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="increment-4">&nbsp;</a>

### increment
```php
Rds::increment(  $keyName,  $value = 1 )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="reset-8">&nbsp;</a>

### reset
```php
Rds::reset(  $keyName )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |




---

<a name="phwoolcon-cache-backend-redis">&nbsp;</a>

## Phwoolcon\Cache\Backend\Redis
Class Redis





<a name="-connect">&nbsp;</a>

### _connect
```php
Redis::_connect(  )
```










---

<a name="decrement-5">&nbsp;</a>

### decrement
```php
Redis::decrement(  $keyName = null,  $value = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="delete-4">&nbsp;</a>

### delete
```php
Redis::delete(  $keyName )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |




---

<a name="exists-2">&nbsp;</a>

### exists
```php
Redis::exists(  $keyName = null,  $lifetime = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |
| $lifetime | **mixed** | &nbsp; |




---

<a name="flush-3">&nbsp;</a>

### flush
```php
Redis::flush(  )
```










---

<a name="get-4">&nbsp;</a>

### get
```php
Redis::get(  $keyName,  $lifetime = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |
| $lifetime | **mixed** | &nbsp; |




---

<a name="increment-5">&nbsp;</a>

### increment
```php
Redis::increment(  $keyName = null,  $value = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="querykeys-1">&nbsp;</a>

### queryKeys
```php
Redis::queryKeys(  $prefix = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $prefix | **mixed** | &nbsp; |




---

<a name="save">&nbsp;</a>

### save
```php
Redis::save(  $keyName = null,  $content = null,  $lifetime = null,  $stopBuffer = true )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $keyName | **mixed** | &nbsp; |
| $content | **mixed** | &nbsp; |
| $lifetime | **mixed** | &nbsp; |
| $stopBuffer | **mixed** | &nbsp; |




---

<a name="phwoolcon-session-adapter-redis">&nbsp;</a>

## Phwoolcon\Session\Adapter\Redis
Class Redis



* **Implements**: \Phwoolcon\Session\AdapterInterface


<a name="--construct-18">&nbsp;</a>

### __construct
```php
Redis::__construct( array $options = array() )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **array** | &nbsp; |




---

<a name="clear">&nbsp;</a>

### clear
```php
Redis::clear(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::clear()




---

<a name="clearformdata">&nbsp;</a>

### clearFormData
```php
Redis::clearFormData(  $key )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::clearFormData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="end">&nbsp;</a>

### end
```php
Redis::end(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::end()




---

<a name="flush-4">&nbsp;</a>

### flush
```php
Redis::flush(  )
```






* **Overrides** \Phwoolcon\Session\AdapterTrait::flush()




---

<a name="generatecsrftoken">&nbsp;</a>

### generateCsrfToken
```php
Redis::generateCsrfToken(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::generateCsrfToken()




---

<a name="get-3">&nbsp;</a>

### get
```php
Redis::get(  $index,  $defaultValue = null,  $remove = false )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::get()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **mixed** | &nbsp; |
| $defaultValue | **mixed** | &nbsp; |
| $remove | **mixed** | &nbsp; |




---

<a name="getcsrftoken">&nbsp;</a>

### getCsrfToken
```php
Redis::getCsrfToken(  $renew = false )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::getCsrfToken()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $renew | **mixed** | &nbsp; |




---

<a name="getformdata">&nbsp;</a>

### getFormData
```php
Redis::getFormData(  $key,  $default = null )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::getFormData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="getredis">&nbsp;</a>

### getRedis <kbd>magic</kbd>
```php
Redis::getRedis(  ): \Phwoolcon\Cache\Backend\Redis
```










---

<a name="readcookieandstart">&nbsp;</a>

### readCookieAndStart
```php
Redis::readCookieAndStart(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::readCookieAndStart()




---

<a name="regenerateid">&nbsp;</a>

### regenerateId
```php
Redis::regenerateId(  $deleteOldSession = true )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::regenerateId()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $deleteOldSession | **mixed** | &nbsp; |




---

<a name="rememberformdata">&nbsp;</a>

### rememberFormData
```php
Redis::rememberFormData(  $key,  $data )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::rememberFormData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $data | **mixed** | &nbsp; |




---

<a name="remove">&nbsp;</a>

### remove
```php
Redis::remove(  $index )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::remove()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **mixed** | &nbsp; |




---

<a name="set-3">&nbsp;</a>

### set
```php
Redis::set(  $index,  $value )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::set()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setcookie">&nbsp;</a>

### setCookie
```php
Redis::setCookie(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::setCookie()




---

<a name="start">&nbsp;</a>

### start
```php
Redis::start(  )
```






* **Inherits** \Phwoolcon\Session\AdapterTrait::start()




---

<a name="phwoolcon-router">&nbsp;</a>

## Phwoolcon\Router
Class Router



* **Implements**: \Phwoolcon\Daemon\ServiceAwareInterface


<a name="--construct-19">&nbsp;</a>

### __construct
```php
Router::__construct(  )
```










---

<a name="add-1">&nbsp;</a>

### add <kbd>magic</kbd>
```php
Router::add( mixed $pattern, mixed $paths = null, mixed $httpMethods = null, mixed $position = Router::POSITION_LAST ): \Phalcon\Mvc\Router\Route
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $pattern | **mixed** | &nbsp; |
| $paths | **mixed** | &nbsp; |
| $httpMethods | **mixed** | &nbsp; |
| $position | **mixed** | &nbsp; |




---

<a name="addroutes">&nbsp;</a>

### addRoutes
```php
Router::addRoutes( array $routes,  $prefix = null,  $filter = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $routes | **array** | &nbsp; |
| $prefix | **mixed** | &nbsp; |
| $filter | **mixed** | &nbsp; |




---

<a name="checkcsrftoken">&nbsp;</a>

### checkCsrfToken <kbd>static</kbd>
```php
Router::checkCsrfToken(  )
```










---

<a name="clearcache-2">&nbsp;</a>

### clearCache <kbd>static</kbd>
```php
Router::clearCache(  )
```










---

<a name="disablecsrfcheck">&nbsp;</a>

### disableCsrfCheck <kbd>static</kbd>
```php
Router::disableCsrfCheck(  )
```










---

<a name="disablesession">&nbsp;</a>

### disableSession <kbd>static</kbd>
```php
Router::disableSession(  )
```










---

<a name="dispatch">&nbsp;</a>

### dispatch <kbd>static</kbd>
```php
Router::dispatch(  $uri = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $uri | **mixed** | &nbsp; |




---

<a name="generateerrorpage">&nbsp;</a>

### generateErrorPage <kbd>static</kbd>
```php
Router::generateErrorPage(  $template,  $pateTitle )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $template | **mixed** | &nbsp; |
| $pateTitle | **mixed** | &nbsp; |




---

<a name="getcurrenturi">&nbsp;</a>

### getCurrentUri <kbd>static</kbd>
```php
Router::getCurrentUri(  )
```










---

<a name="litehandle">&nbsp;</a>

### liteHandle
```php
Router::liteHandle(  $uri )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $uri | **mixed** | &nbsp; |




---

<a name="prefix">&nbsp;</a>

### prefix
```php
Router::prefix(  $prefix, array $routes,  $filter = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $prefix | **mixed** | &nbsp; |
| $routes | **array** | &nbsp; |
| $filter | **mixed** | &nbsp; |




---

<a name="quickadd">&nbsp;</a>

### quickAdd
```php
Router::quickAdd(  $method,  $uri,  $handler,  $filter = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $method | **mixed** | &nbsp; |
| $uri | **mixed** | &nbsp; |
| $handler | **mixed** | &nbsp; |
| $filter | **mixed** | &nbsp; |




---

<a name="register-13">&nbsp;</a>

### register <kbd>static</kbd>
```php
Router::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="reset-9">&nbsp;</a>

### reset
```php
Router::reset(  )
```






* **Implements** \Phwoolcon\Daemon\ServiceAwareInterface::reset()




---

<a name="staticreset-1">&nbsp;</a>

### staticReset <kbd>static</kbd>
```php
Router::staticReset(  )
```










---

<a name="throw404exception">&nbsp;</a>

### throw404Exception <kbd>static</kbd>
```php
Router::throw404Exception(  $content = null,  $contentType = 'text/html' )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $content | **mixed** | &nbsp; |
| $contentType | **mixed** | &nbsp; |




---

<a name="throwcsrfexception">&nbsp;</a>

### throwCsrfException <kbd>static</kbd>
```php
Router::throwCsrfException(  $content = null,  $contentType = 'text/html' )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $content | **mixed** | &nbsp; |
| $contentType | **mixed** | &nbsp; |




---

<a name="uselitehandler">&nbsp;</a>

### useLiteHandler <kbd>static</kbd>
```php
Router::useLiteHandler(  $flag = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $flag | **mixed** | &nbsp; |




---

<a name="phwoolcon-security">&nbsp;</a>

## Phwoolcon\Security






<a name="preparesignaturedata">&nbsp;</a>

### prepareSignatureData <kbd>static</kbd>
```php
Security::prepareSignatureData( array $data )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $data | **array** | &nbsp; |




---

<a name="sha256">&nbsp;</a>

### sha256 <kbd>static</kbd>
```php
Security::sha256(  $data,  $raw = false )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $data | **mixed** | &nbsp; |
| $raw | **mixed** | &nbsp; |




---

<a name="signarrayhmacsha256">&nbsp;</a>

### signArrayHmacSha256 <kbd>static</kbd>
```php
Security::signArrayHmacSha256( array $data,  $secret )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $data | **array** | &nbsp; |
| $secret | **mixed** | &nbsp; |




---

<a name="signarraymd5">&nbsp;</a>

### signArrayMd5 <kbd>static</kbd>
```php
Security::signArrayMd5( array $data,  $secret )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $data | **array** | &nbsp; |
| $secret | **mixed** | &nbsp; |




---

<a name="signarraysha256">&nbsp;</a>

### signArraySha256 <kbd>static</kbd>
```php
Security::signArraySha256( array $data,  $secret )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $data | **array** | &nbsp; |
| $secret | **mixed** | &nbsp; |




---

<a name="phwoolcon-daemon-service">&nbsp;</a>

## Phwoolcon\Daemon\Service






<a name="--construct-20">&nbsp;</a>

### __construct
```php
Service::__construct(  $config )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $config | **mixed** | &nbsp; |




---

<a name="chooseport">&nbsp;</a>

### choosePort
```php
Service::choosePort( boolean $swap = false ): integer
```

Choose a port in [9502, 9503] to serve





**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $swap | **boolean** | True to swap port, otherwise remain previous port |


**Return Value:**

Return previous port



---

<a name="getname-1">&nbsp;</a>

### getName
```php
Service::getName(  ): string
```










---

<a name="onmanagerstart">&nbsp;</a>

### onManagerStart
```php
Service::onManagerStart( \Swoole\Server $server )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $server | **\Swoole\Server** | &nbsp; |




---

<a name="onreceive">&nbsp;</a>

### onReceive
```php
Service::onReceive( \Swoole\Server $server,  $fd,  $fromId,  $data )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $server | **\Swoole\Server** | &nbsp; |
| $fd | **mixed** | &nbsp; |
| $fromId | **mixed** | &nbsp; |
| $data | **mixed** | &nbsp; |




---

<a name="onshutdown">&nbsp;</a>

### onShutdown
```php
Service::onShutdown( \Swoole\Server $server )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $server | **\Swoole\Server** | &nbsp; |




---

<a name="onstart">&nbsp;</a>

### onStart
```php
Service::onStart( \Swoole\Server $server )
```

Callback after service started





**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $server | **\Swoole\Server** | &nbsp; |




---

<a name="onworkerstart">&nbsp;</a>

### onWorkerStart
```php
Service::onWorkerStart( \Swoole\Server $server,  $workerId )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $server | **\Swoole\Server** | &nbsp; |
| $workerId | **mixed** | &nbsp; |




---

<a name="profilereceive">&nbsp;</a>

### profileReceive
```php
Service::profileReceive( \Swoole\Server $server,  $fd,  $fromId,  $data )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $server | **\Swoole\Server** | &nbsp; |
| $fd | **mixed** | &nbsp; |
| $fromId | **mixed** | &nbsp; |
| $data | **mixed** | &nbsp; |




---

<a name="register-14">&nbsp;</a>

### register <kbd>static</kbd>
```php
Service::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="reset-10">&nbsp;</a>

### reset
```php
Service::reset(  )
```










---

<a name="sendcommand">&nbsp;</a>

### sendCommand
```php
Service::sendCommand( string $command, integer $port = null,  &$error = null ): string
```

Send command to service command handler





**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $command | **string** | &nbsp; |
| $port | **integer** | &nbsp; |
| $error | **mixed** | &nbsp; |




---

<a name="setclicommand">&nbsp;</a>

### setCliCommand
```php
Service::setCliCommand( \Phwoolcon\Cli\Command $command ): $this
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $command | **\Phwoolcon\Cli\Command** | &nbsp; |




---

<a name="shift">&nbsp;</a>

### shift
```php
Service::shift(  ): $this
```

Mark running instance as old








---

<a name="showstatus">&nbsp;</a>

### showStatus
```php
Service::showStatus(  $port = null,  $exit = true,  &$error = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $port | **mixed** | &nbsp; |
| $exit | **mixed** | &nbsp; |
| $error | **mixed** | &nbsp; |




---

<a name="start-1">&nbsp;</a>

### start
```php
Service::start(  $dryRun = false )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $dryRun | **mixed** | &nbsp; |




---

<a name="stop">&nbsp;</a>

### stop
```php
Service::stop( string $instance = 'current' )
```

Stop service





**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $instance | **string** | Specify "current" or "old". "current" by default. |




---

<a name="phwoolcon-cli-command-servicecommand">&nbsp;</a>

## Phwoolcon\Cli\Command\ServiceCommand




* Parent class: Phwoolcon\Cli\Command


<a name="--construct-4">&nbsp;</a>

### __construct
```php
ServiceCommand::__construct(  $name, \Phalcon\Di $di )
```






* **Inherits** \Phwoolcon\Cli\Command::__construct()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="ask">&nbsp;</a>

### ask
```php
ServiceCommand::ask(  $question,  $default = null )
```






* **Inherits** \Phwoolcon\Cli\Command::ask()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="comment">&nbsp;</a>

### comment
```php
ServiceCommand::comment(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::comment()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="confirm">&nbsp;</a>

### confirm
```php
ServiceCommand::confirm(  $question,  $default = true )
```






* **Inherits** \Phwoolcon\Cli\Command::confirm()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $question | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="createprogressbar">&nbsp;</a>

### createProgressBar
```php
ServiceCommand::createProgressBar(  $max )
```






* **Inherits** \Phwoolcon\Cli\Command::createProgressBar()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $max | **mixed** | &nbsp; |




---

<a name="error">&nbsp;</a>

### error
```php
ServiceCommand::error(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::error()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="execute">&nbsp;</a>

### execute
```php
ServiceCommand::execute( \Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output )
```






* **Inherits** \Phwoolcon\Cli\Command::execute()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $input | **\Symfony\Component\Console\Input\InputInterface** | &nbsp; |
| $output | **\Symfony\Component\Console\Output\OutputInterface** | &nbsp; |




---

<a name="fire-8">&nbsp;</a>

### fire
```php
ServiceCommand::fire(  )
```






* **Overrides** \Phwoolcon\Cli\Command::fire()




---

<a name="getdi-1">&nbsp;</a>

### getDi
```php
ServiceCommand::getDi(  ): \Phalcon\Di
```






* **Inherits** \Phwoolcon\Cli\Command::getDi()




---

<a name="info">&nbsp;</a>

### info
```php
ServiceCommand::info(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::info()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="question">&nbsp;</a>

### question
```php
ServiceCommand::question(  $messages )
```






* **Inherits** \Phwoolcon\Cli\Command::question()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $messages | **mixed** | &nbsp; |




---

<a name="setdi">&nbsp;</a>

### setDi
```php
ServiceCommand::setDi( \Phalcon\Di $di ): $this
```






* **Inherits** \Phwoolcon\Cli\Command::setDi()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="phwoolcon-session">&nbsp;</a>

## Phwoolcon\Session
Class Session





<a name="--callstatic-3">&nbsp;</a>

### __callStatic <kbd>static</kbd>
```php
Session::__callStatic(  $name,  $arguments )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $arguments | **mixed** | &nbsp; |




---

<a name="clear-1">&nbsp;</a>

### clear <kbd>magic</kbd>
```php
Session::clear(  ): void
```










---

<a name="clearformdata-1">&nbsp;</a>

### clearFormData <kbd>magic</kbd>
```php
Session::clearFormData( string $key ): void
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **string** | &nbsp; |




---

<a name="destroy">&nbsp;</a>

### destroy <kbd>magic</kbd>
```php
Session::destroy( boolean $removeData = false ): boolean
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $removeData | **boolean** | &nbsp; |




---

<a name="end-1">&nbsp;</a>

### end <kbd>magic</kbd>
```php
Session::end(  ): void
```










---

<a name="flush-5">&nbsp;</a>

### flush <kbd>magic</kbd>
```php
Session::flush(  ): void
```










---

<a name="generatecsrftoken-1">&nbsp;</a>

### generateCsrfToken <kbd>magic</kbd>
```php
Session::generateCsrfToken(  ): string
```










---

<a name="generaterandomstring">&nbsp;</a>

### generateRandomString <kbd>magic</kbd>
```php
Session::generateRandomString(  ): string
```










---

<a name="get-5">&nbsp;</a>

### get <kbd>magic</kbd>
```php
Session::get( string $index, mixed $defaultValue = null, boolean $remove = false ): mixed
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **string** | &nbsp; |
| $defaultValue | **mixed** | &nbsp; |
| $remove | **boolean** | &nbsp; |




---

<a name="getcsrftoken-1">&nbsp;</a>

### getCsrfToken <kbd>magic</kbd>
```php
Session::getCsrfToken( boolean $renew = false ): string
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $renew | **boolean** | &nbsp; |




---

<a name="getformdata-1">&nbsp;</a>

### getFormData <kbd>magic</kbd>
```php
Session::getFormData( string $key, mixed $default = null ): mixed
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **string** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="getid-1">&nbsp;</a>

### getId <kbd>magic</kbd>
```php
Session::getId(  ): string
```










---

<a name="getname-2">&nbsp;</a>

### getName <kbd>magic</kbd>
```php
Session::getName(  ): string
```










---

<a name="getoptions">&nbsp;</a>

### getOptions <kbd>magic</kbd>
```php
Session::getOptions(  ): array
```










---

<a name="has">&nbsp;</a>

### has <kbd>magic</kbd>
```php
Session::has( string $index ): boolean
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **string** | &nbsp; |




---

<a name="isstarted">&nbsp;</a>

### isStarted <kbd>magic</kbd>
```php
Session::isStarted(  ): boolean
```










---

<a name="regenerateid-1">&nbsp;</a>

### regenerateId <kbd>magic</kbd>
```php
Session::regenerateId( boolean $deleteOldSession = true ): \Phwoolcon\Session\AdapterTrait
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $deleteOldSession | **boolean** | &nbsp; |




---

<a name="register-15">&nbsp;</a>

### register <kbd>static</kbd>
```php
Session::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="rememberformdata-1">&nbsp;</a>

### rememberFormData <kbd>magic</kbd>
```php
Session::rememberFormData( string $key, mixed $data ): void
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **string** | &nbsp; |
| $data | **mixed** | &nbsp; |




---

<a name="remove-2">&nbsp;</a>

### remove <kbd>magic</kbd>
```php
Session::remove( string $index ): void
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **string** | &nbsp; |




---

<a name="set-4">&nbsp;</a>

### set <kbd>magic</kbd>
```php
Session::set( string $index, mixed $value ): void
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $index | **string** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setcookie-1">&nbsp;</a>

### setCookie <kbd>magic</kbd>
```php
Session::setCookie(  ): \Phwoolcon\Session\AdapterTrait
```










---

<a name="setid-1">&nbsp;</a>

### setId <kbd>magic</kbd>
```php
Session::setId( string $id ): void
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $id | **string** | &nbsp; |




---

<a name="setname">&nbsp;</a>

### setName <kbd>magic</kbd>
```php
Session::setName( string $id ): void
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $id | **string** | &nbsp; |




---

<a name="setoptions">&nbsp;</a>

### setOptions <kbd>magic</kbd>
```php
Session::setOptions( array $options ): void
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **array** | &nbsp; |




---

<a name="start-2">&nbsp;</a>

### start <kbd>magic</kbd>
```php
Session::start(  ): boolean
```










---

<a name="status">&nbsp;</a>

### status <kbd>magic</kbd>
```php
Session::status(  ): integer
```










---

<a name="phwoolcon-exception-sessionexception">&nbsp;</a>

## Phwoolcon\Exception\SessionException






<a name="phwoolcon-cli-output-stream">&nbsp;</a>

## Phwoolcon\Cli\Output\Stream




* **Implements**: \Phwoolcon\Protocol\StreamWrapperInterface


<a name="--construct-21">&nbsp;</a>

### __construct
```php
Stream::__construct(  )
```






* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::__construct()




---

<a name="dir-closedir">&nbsp;</a>

### dir_closedir
```php
Stream::dir_closedir(  ): boolean
```

Close directory handle




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::dir_closedir()


**Return Value:**

Returns TRUE on success or FALSE on failure.



---

<a name="dir-opendir">&nbsp;</a>

### dir_opendir
```php
Stream::dir_opendir( string $path, integer $options ): boolean
```

Open directory handle




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::dir_opendir()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **string** | Specifies the URL that was passed to opendir(). |
| $options | **integer** | Whether or not to enforce safe_mode (0x04). |




---

<a name="dir-readdir">&nbsp;</a>

### dir_readdir
```php
Stream::dir_readdir(  ): string|false
```

Read entry from directory handle




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::dir_readdir()


**Return Value:**

Should return string representing the next filename, or FALSE if there is no next file.



---

<a name="dir-rewinddir">&nbsp;</a>

### dir_rewinddir
```php
Stream::dir_rewinddir(  ): boolean
```

Rewind directory handle




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::dir_rewinddir()


**Return Value:**

Returns TRUE on success or FALSE on failure.



---

<a name="mkdir">&nbsp;</a>

### mkdir
```php
Stream::mkdir( string $path, integer $mode, integer $options ): boolean
```

Create a directory




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::mkdir()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **string** | Directory which should be created. |
| $mode | **integer** | The value passed to mkdir(). |
| $options | **integer** | A bitwise mask of values, such as STREAM_MKDIR_RECURSIVE. |


**Return Value:**

Returns TRUE on success or FALSE on failure.



---

<a name="rename">&nbsp;</a>

### rename
```php
Stream::rename( string $pathFrom, string $pathTo ): boolean
```

Renames a file or directory




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::rename()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $pathFrom | **string** | The URL to the current file. |
| $pathTo | **string** | he URL which the $pathFrom should be renamed to. |


**Return Value:**

Returns TRUE on success or FALSE on failure.



---

<a name="rmdir">&nbsp;</a>

### rmdir
```php
Stream::rmdir( string $path, integer $options ): boolean
```

Removes a directory




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::rmdir()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **string** | The directory URL which should be removed. |
| $options | **integer** | A bitwise mask of values, such as STREAM_MKDIR_RECURSIVE. |


**Return Value:**

Returns TRUE on success or FALSE on failure.



---

<a name="stream-cast">&nbsp;</a>

### stream_cast
```php
Stream::stream_cast( integer $castAs ): resource|false
```

Retrieve the underlaying resource




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::stream_cast()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $castAs | **integer** | STREAM_CAST_FOR_SELECT or STREAM_CAST_AS_STREAM |


**Return Value:**

Should return the underlying stream resource used by the wrapper, or FALSE.



---

<a name="stream-close">&nbsp;</a>

### stream_close
```php
Stream::stream_close(  )
```

Close a resource




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::stream_close()




---

<a name="stream-eof">&nbsp;</a>

### stream_eof
```php
Stream::stream_eof(  ): boolean
```

Tests for end-of-file on a file pointer




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::stream_eof()


**Return Value:**

Should return TRUE if the read/write position is at the end of the stream and if no more data is
             available to be read, or FALSE otherwise.



---

<a name="stream-flush">&nbsp;</a>

### stream_flush
```php
Stream::stream_flush(  ): boolean
```

Flushes the output




* **Implements** \Phwoolcon\Protocol\StreamWrapperInterface::stream_flush()
* **Overrides** \Phwoolcon\Protocol\StreamWrapperTrait::stream_flush()


**Return Value:**

Should return TRUE if the cached data was successfully stored (or if there was no data to store),
             or FALSE if the data could not be stored.



---

<a name="stream-lock">&nbsp;</a>

### stream_lock
```php
Stream::stream_lock( integer $operation ): boolean
```

Advisory file locking




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::stream_lock()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $operation | **integer** | LOCK_SH to acquire a shared lock (reader).
                      LOCK_EX to acquire an exclusive lock (writer).
                      LOCK_UN to release a lock (shared or exclusive).
                      LOCK_NB if you don't want flock() to block while locking. (not supported on Windows) |


**Return Value:**

Returns TRUE on success or FALSE on failure.



---

<a name="stream-metadata">&nbsp;</a>

### stream_metadata
```php
Stream::stream_metadata( string $path, integer $option, mixed $value ): boolean
```

Change stream options




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::stream_metadata()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **string** | The file path or URL to set metadata. |
| $option | **integer** | One of: STREAM_META_TOUCH, STREAM_META_OWNER_NAME, STREAM_META_OWNER,
                      STREAM_META_GROUP_NAME, STREAM_META_GROUP, STREAM_META_ACCESS |
| $value | **mixed** | If option is:
                      STREAM_META_TOUCH: Array consisting of two arguments of the touch() function.
                      STREAM_META_OWNER_NAME, STREAM_META_GROUP_NAME: The name of the owner user/group as string.
                      STREAM_META_OWNER, STREAM_META_GROUP: The value owner user/group argument as integer.
                      STREAM_META_ACCESS: The argument of the chmod() as integer. |


**Return Value:**

Returns TRUE on success or FALSE on failure. If option is not implemented, FALSE should be
             returned.



---

<a name="stream-open">&nbsp;</a>

### stream_open
```php
Stream::stream_open( string $path, string $mode, integer $options,  &$openedPath ): boolean
```

Opens file or URL




* **Implements** \Phwoolcon\Protocol\StreamWrapperInterface::stream_open()
* **Overrides** \Phwoolcon\Protocol\StreamWrapperTrait::stream_open()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **string** | Specifies the URL that was passed to the original function. |
| $mode | **string** | The mode used to open the file, as detailed for fopen(). |
| $options | **integer** | STREAM_USE_PATH or STREAM_REPORT_ERRORS |
| $openedPath | **mixed** | &nbsp; |


**Return Value:**

Returns TRUE on success or FALSE on failure.



---

<a name="stream-read">&nbsp;</a>

### stream_read
```php
Stream::stream_read( integer $count ): string|false
```

Read from stream




* **Implements** \Phwoolcon\Protocol\StreamWrapperInterface::stream_read()
* **Overrides** \Phwoolcon\Protocol\StreamWrapperTrait::stream_read()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $count | **integer** | How many bytes of data from the current position should be returned. |


**Return Value:**

If there are less than count bytes available, return as many as are available.
                     If no more data is available, return either FALSE or an empty string.



---

<a name="stream-seek">&nbsp;</a>

### stream_seek
```php
Stream::stream_seek( integer $offset, integer $whence = SEEK_SET ): boolean
```

Seeks to specific location in a stream




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::stream_seek()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $offset | **integer** | The stream offset to seek to. |
| $whence | **integer** | SEEK_SET, SEEK_CUR or SEEK_END |


**Return Value:**

Return TRUE if the position was updated, FALSE otherwise.



---

<a name="stream-set-option">&nbsp;</a>

### stream_set_option
```php
Stream::stream_set_option( integer $option, integer $arg1, integer $arg2 ): boolean
```

Change stream options




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::stream_set_option()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $option | **integer** | STREAM_OPTION_BLOCKING, STREAM_OPTION_READ_TIMEOUT or STREAM_OPTION_WRITE_BUFFER |
| $arg1 | **integer** | If option is:
                   STREAM_OPTION_BLOCKING: requested blocking mode (1 meaning block 0 not blocking).
                   STREAM_OPTION_READ_TIMEOUT: the timeout in seconds.
                   STREAM_OPTION_WRITE_BUFFER: buffer mode (STREAM_BUFFER_NONE or STREAM_BUFFER_FULL). |
| $arg2 | **integer** | If option is:
                   STREAM_OPTION_BLOCKING: This option is not set.
                   STREAM_OPTION_READ_TIMEOUT: the timeout in microseconds.
                   STREAM_OPTION_WRITE_BUFFER: the requested buffer size. |


**Return Value:**

Returns TRUE on success or FALSE on failure. If option is not implemented, FALSE should be returned.



---

<a name="stream-stat">&nbsp;</a>

### stream_stat
```php
Stream::stream_stat(  ): array
```

Retrieve information about a file resource




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::stream_stat()


**Return Value:**

See stat().


**See Also:**

* \Phwoolcon\Protocol\stat() 

---

<a name="stream-tell">&nbsp;</a>

### stream_tell
```php
Stream::stream_tell(  ): integer
```

Retrieve the current position of a stream




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::stream_tell()


**Return Value:**

Should return the current position of the stream.



---

<a name="stream-truncate">&nbsp;</a>

### stream_truncate
```php
Stream::stream_truncate( integer $newSize ): boolean
```

Truncate stream




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::stream_truncate()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $newSize | **integer** | The new size. |


**Return Value:**

Returns TRUE on success or FALSE on failure.



---

<a name="stream-write">&nbsp;</a>

### stream_write
```php
Stream::stream_write( string $data ): integer
```

Write to stream




* **Implements** \Phwoolcon\Protocol\StreamWrapperInterface::stream_write()
* **Overrides** \Phwoolcon\Protocol\StreamWrapperTrait::stream_write()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $data | **string** | The data should be stored into the underlying stream. |


**Return Value:**

Should return the number of bytes that were successfully stored, or 0 if none could be stored.



---

<a name="unlink">&nbsp;</a>

### unlink
```php
Stream::unlink( string $path ): boolean
```

Delete a file




* **Implements** \Phwoolcon\Protocol\StreamWrapperInterface::unlink()
* **Overrides** \Phwoolcon\Protocol\StreamWrapperTrait::unlink()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **string** | The file URL which should be deleted. |


**Return Value:**

Returns TRUE on success or FALSE on failure.



---

<a name="url-stat">&nbsp;</a>

### url_stat
```php
Stream::url_stat( string $path, integer $flags ): array
```

Retrieve information about a file




* **Inherits** \Phwoolcon\Protocol\StreamWrapperTrait::url_stat()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **string** | The file path or URL to stat. |
| $flags | **integer** | STREAM_URL_STAT_LINK or STREAM_URL_STAT_QUIET |


**Return Value:**

Should return as many elements as stat() does.
              Unknown or unavailable values should be set to a rational value (usually 0).



---

<a name="phwoolcon-text">&nbsp;</a>

## Phwoolcon\Text






<a name="ellipsis">&nbsp;</a>

### ellipsis <kbd>static</kbd>
```php
Text::ellipsis(  $string,  $length,  $suffix = '...' )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $string | **mixed** | &nbsp; |
| $length | **mixed** | &nbsp; |
| $suffix | **mixed** | &nbsp; |




---

<a name="escapehtml">&nbsp;</a>

### escapeHtml <kbd>static</kbd>
```php
Text::escapeHtml(  $string,  $newLineToBr = true )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $string | **mixed** | &nbsp; |
| $newLineToBr | **mixed** | &nbsp; |




---

<a name="padortruncate">&nbsp;</a>

### padOrTruncate <kbd>static</kbd>
```php
Text::padOrTruncate( string $input, string $padding, integer $length ): string
```

Pad or truncate input string to fixed length

```php
echo Phwoolcon\Text::padOrTruncate('123', '0', 4);       // prints 0123
echo Phwoolcon\Text::padOrTruncate('123456', '0', 4);    // prints 3456
```





**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $input | **string** | &nbsp; |
| $padding | **string** | &nbsp; |
| $length | **integer** | &nbsp; |




---

<a name="token">&nbsp;</a>

### token <kbd>static</kbd>
```php
Text::token(  )
```










---

<a name="phwoolcon-util-timer">&nbsp;</a>

## Phwoolcon\Util\Timer






<a name="start-3">&nbsp;</a>

### start <kbd>static</kbd>
```php
Timer::start(  )
```










---

<a name="stop-1">&nbsp;</a>

### stop <kbd>static</kbd>
```php
Timer::stop(  )
```










---

<a name="phwoolcon-model-user">&nbsp;</a>

## Phwoolcon\Model\User
Class User



* Parent class: Phwoolcon\Model


<a name="--call">&nbsp;</a>

### __call
```php
User::__call(  $method,  $arguments )
```






* **Inherits** \Phwoolcon\Model::__call()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $method | **mixed** | &nbsp; |
| $arguments | **mixed** | &nbsp; |




---

<a name="adddata">&nbsp;</a>

### addData
```php
User::addData( array $data )
```






* **Inherits** \Phwoolcon\Model::addData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $data | **array** | &nbsp; |




---

<a name="afterfetch">&nbsp;</a>

### afterFetch
```php
User::afterFetch(  )
```






* **Inherits** \Phwoolcon\Model::afterFetch()




---

<a name="buildparams">&nbsp;</a>

### buildParams <kbd>static</kbd>
```php
User::buildParams(  $conditions = array(), array $bind = array(), string $orderBy = null, string $columns = null, string|integer $limit = null ): array
```






* **Inherits** \Phwoolcon\Model::buildParams()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **mixed** | &nbsp; |
| $bind | **array** | &nbsp; |
| $orderBy | **string** | &nbsp; |
| $columns | **string** | &nbsp; |
| $limit | **string&#124;integer** | &nbsp; |




---

<a name="checkdatacolumn">&nbsp;</a>

### checkDataColumn
```php
User::checkDataColumn(  $column = null )
```






* **Inherits** \Phwoolcon\Model::checkDataColumn()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $column | **mixed** | &nbsp; |




---

<a name="cleardata">&nbsp;</a>

### clearData
```php
User::clearData(  )
```






* **Inherits** \Phwoolcon\Model::clearData()




---

<a name="countsimple">&nbsp;</a>

### countSimple <kbd>static</kbd>
```php
User::countSimple( array $conditions = array(), array $bind = array() ): mixed
```






* **Inherits** \Phwoolcon\Model::countSimple()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **array** | &nbsp; |
| $bind | **array** | &nbsp; |




---

<a name="findfirstsimple">&nbsp;</a>

### findFirstSimple <kbd>static</kbd>
```php
User::findFirstSimple( array|string $conditions, array $bind = array(), string $order = null, string $columns = null ): $this|false
```






* **Inherits** \Phwoolcon\Model::findFirstSimple()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **array&#124;string** | &nbsp; |
| $bind | **array** | &nbsp; |
| $order | **string** | &nbsp; |
| $columns | **string** | &nbsp; |




---

<a name="findsimple">&nbsp;</a>

### findSimple <kbd>static</kbd>
```php
User::findSimple(  $conditions = array(), array $bind = array(), string $order = null, string $columns = null, string|integer $limit = null ): \Phalcon\Mvc\Model\Resultset\Simple|\Phalcon\Mvc\Model\ResultsetInterface
```






* **Inherits** \Phwoolcon\Model::findSimple()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **mixed** | &nbsp; |
| $bind | **array** | &nbsp; |
| $order | **string** | &nbsp; |
| $columns | **string** | &nbsp; |
| $limit | **string&#124;integer** | &nbsp; |




---

<a name="generatedistributedid">&nbsp;</a>

### generateDistributedId
```php
User::generateDistributedId(  )
```






* **Inherits** \Phwoolcon\Model::generateDistributedId()




---

<a name="getadditionaldata">&nbsp;</a>

### getAdditionalData
```php
User::getAdditionalData(  $key = null )
```






* **Inherits** \Phwoolcon\Model::getAdditionalData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="getavatar">&nbsp;</a>

### getAvatar
```php
User::getAvatar(  )
```










---

<a name="getdata">&nbsp;</a>

### getData
```php
User::getData(  $key = null )
```






* **Inherits** \Phwoolcon\Model::getData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="getemail">&nbsp;</a>

### getEmail <kbd>magic</kbd>
```php
User::getEmail(  ): string
```










---

<a name="getid">&nbsp;</a>

### getId
```php
User::getId(  )
```






* **Inherits** \Phwoolcon\Model::getId()




---

<a name="getinjectedclass">&nbsp;</a>

### getInjectedClass
```php
User::getInjectedClass(  $class )
```






* **Inherits** \Phwoolcon\Model::getInjectedClass()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $class | **mixed** | &nbsp; |




---

<a name="getmessages-2">&nbsp;</a>

### getMessages <kbd>magic</kbd>
```php
User::getMessages( string $filter = null ): array<mixed,\Phalcon\Mvc\Model\Message>
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $filter | **string** | &nbsp; |




---

<a name="getmobile">&nbsp;</a>

### getMobile <kbd>magic</kbd>
```php
User::getMobile(  ): string
```










---

<a name="getremembertoken">&nbsp;</a>

### getRememberToken
```php
User::getRememberToken(  )
```










---

<a name="getstringmessages">&nbsp;</a>

### getStringMessages
```php
User::getStringMessages(  )
```






* **Inherits** \Phwoolcon\Model::getStringMessages()




---

<a name="getuserprofile">&nbsp;</a>

### getUserProfile <kbd>magic</kbd>
```php
User::getUserProfile(  ): \Phwoolcon\Model\UserProfile|false
```










---

<a name="getusername">&nbsp;</a>

### getUsername <kbd>magic</kbd>
```php
User::getUsername(  ): string
```










---

<a name="getwriteconnection-2">&nbsp;</a>

### getWriteConnection <kbd>magic</kbd>
```php
User::getWriteConnection(  ): \Phwoolcon\Db\Adapter\Pdo\Mysql|\Phalcon\Db\Adapter\Pdo
```










---

<a name="initialize-2">&nbsp;</a>

### initialize
```php
User::initialize(  )
```

Runs once, only when the model instance is created at the first time




* **Overrides** \Phwoolcon\Model::initialize()




---

<a name="isnew">&nbsp;</a>

### isNew
```php
User::isNew(  )
```






* **Inherits** \Phwoolcon\Model::isNew()




---

<a name="removeremembertoken">&nbsp;</a>

### removeRememberToken
```php
User::removeRememberToken(  )
```










---

<a name="reset-2">&nbsp;</a>

### reset
```php
User::reset(  )
```






* **Inherits** \Phwoolcon\Model::reset()




---

<a name="setdata">&nbsp;</a>

### setData
```php
User::setData(  $key,  $value = null )
```






* **Inherits** \Phwoolcon\Model::setData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setid">&nbsp;</a>

### setId
```php
User::setId(  $id )
```






* **Inherits** \Phwoolcon\Model::setId()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $id | **mixed** | &nbsp; |




---

<a name="setrelatedrecord">&nbsp;</a>

### setRelatedRecord
```php
User::setRelatedRecord(  $key,  $value )
```






* **Inherits** \Phwoolcon\Model::setRelatedRecord()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setremembertoken">&nbsp;</a>

### setRememberToken
```php
User::setRememberToken(  $rememberToken )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $rememberToken | **mixed** | &nbsp; |




---

<a name="setuserprofile">&nbsp;</a>

### setUserProfile <kbd>magic</kbd>
```php
User::setUserProfile( \UserProfile $profile ): $this
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $profile | **\UserProfile** | &nbsp; |




---

<a name="setusername">&nbsp;</a>

### setUsername <kbd>magic</kbd>
```php
User::setUsername( string $username ): $this
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $username | **string** | &nbsp; |




---

<a name="setup">&nbsp;</a>

### setup <kbd>static</kbd>
```php
User::setup( array $options )
```






* **Inherits** \Phwoolcon\Model::setup()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **array** | &nbsp; |




---

<a name="sqlexecute">&nbsp;</a>

### sqlExecute
```php
User::sqlExecute(  $sql, null $bind = null ): boolean
```






* **Inherits** \Phwoolcon\Model::sqlExecute()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="sqlfetchall">&nbsp;</a>

### sqlFetchAll
```php
User::sqlFetchAll(  $sql, null $bind = null ): array
```






* **Inherits** \Phwoolcon\Model::sqlFetchAll()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="sqlfetchcolumn">&nbsp;</a>

### sqlFetchColumn
```php
User::sqlFetchColumn(  $sql, null $bind = null ): mixed
```






* **Inherits** \Phwoolcon\Model::sqlFetchColumn()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="sqlfetchone">&nbsp;</a>

### sqlFetchOne
```php
User::sqlFetchOne(  $sql, null $bind = null ): array
```






* **Inherits** \Phwoolcon\Model::sqlFetchOne()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="validation">&nbsp;</a>

### validation
```php
User::validation(  )
```






* **Inherits** \Phwoolcon\Model::validation()




---

<a name="phwoolcon-model-userprofile">&nbsp;</a>

## Phwoolcon\Model\UserProfile
Class UserProfile



* Parent class: Phwoolcon\Model


<a name="--call">&nbsp;</a>

### __call
```php
UserProfile::__call(  $method,  $arguments )
```






* **Inherits** \Phwoolcon\Model::__call()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $method | **mixed** | &nbsp; |
| $arguments | **mixed** | &nbsp; |




---

<a name="adddata">&nbsp;</a>

### addData
```php
UserProfile::addData( array $data )
```






* **Inherits** \Phwoolcon\Model::addData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $data | **array** | &nbsp; |




---

<a name="afterfetch">&nbsp;</a>

### afterFetch
```php
UserProfile::afterFetch(  )
```






* **Inherits** \Phwoolcon\Model::afterFetch()




---

<a name="buildparams">&nbsp;</a>

### buildParams <kbd>static</kbd>
```php
UserProfile::buildParams(  $conditions = array(), array $bind = array(), string $orderBy = null, string $columns = null, string|integer $limit = null ): array
```






* **Inherits** \Phwoolcon\Model::buildParams()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **mixed** | &nbsp; |
| $bind | **array** | &nbsp; |
| $orderBy | **string** | &nbsp; |
| $columns | **string** | &nbsp; |
| $limit | **string&#124;integer** | &nbsp; |




---

<a name="checkdatacolumn">&nbsp;</a>

### checkDataColumn
```php
UserProfile::checkDataColumn(  $column = null )
```






* **Inherits** \Phwoolcon\Model::checkDataColumn()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $column | **mixed** | &nbsp; |




---

<a name="cleardata">&nbsp;</a>

### clearData
```php
UserProfile::clearData(  )
```






* **Inherits** \Phwoolcon\Model::clearData()




---

<a name="countsimple">&nbsp;</a>

### countSimple <kbd>static</kbd>
```php
UserProfile::countSimple( array $conditions = array(), array $bind = array() ): mixed
```






* **Inherits** \Phwoolcon\Model::countSimple()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **array** | &nbsp; |
| $bind | **array** | &nbsp; |




---

<a name="findfirstsimple">&nbsp;</a>

### findFirstSimple <kbd>static</kbd>
```php
UserProfile::findFirstSimple( array|string $conditions, array $bind = array(), string $order = null, string $columns = null ): $this|false
```






* **Inherits** \Phwoolcon\Model::findFirstSimple()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **array&#124;string** | &nbsp; |
| $bind | **array** | &nbsp; |
| $order | **string** | &nbsp; |
| $columns | **string** | &nbsp; |




---

<a name="findsimple">&nbsp;</a>

### findSimple <kbd>static</kbd>
```php
UserProfile::findSimple(  $conditions = array(), array $bind = array(), string $order = null, string $columns = null, string|integer $limit = null ): \Phalcon\Mvc\Model\Resultset\Simple|\Phalcon\Mvc\Model\ResultsetInterface
```






* **Inherits** \Phwoolcon\Model::findSimple()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $conditions | **mixed** | &nbsp; |
| $bind | **array** | &nbsp; |
| $order | **string** | &nbsp; |
| $columns | **string** | &nbsp; |
| $limit | **string&#124;integer** | &nbsp; |




---

<a name="generateavatarurl">&nbsp;</a>

### generateAvatarUrl
```php
UserProfile::generateAvatarUrl(  $id = null,  $path = 'uploads/avatar' )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $id | **mixed** | &nbsp; |
| $path | **mixed** | &nbsp; |




---

<a name="generatedistributedid">&nbsp;</a>

### generateDistributedId
```php
UserProfile::generateDistributedId(  )
```






* **Inherits** \Phwoolcon\Model::generateDistributedId()




---

<a name="getadditionaldata">&nbsp;</a>

### getAdditionalData
```php
UserProfile::getAdditionalData(  $key = null )
```






* **Inherits** \Phwoolcon\Model::getAdditionalData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="getavatar-1">&nbsp;</a>

### getAvatar <kbd>magic</kbd>
```php
UserProfile::getAvatar(  ): string
```










---

<a name="getdata">&nbsp;</a>

### getData
```php
UserProfile::getData(  $key = null )
```






* **Inherits** \Phwoolcon\Model::getData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="getextradata">&nbsp;</a>

### getExtraData
```php
UserProfile::getExtraData(  $key = null,  $default = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="getid">&nbsp;</a>

### getId
```php
UserProfile::getId(  )
```






* **Inherits** \Phwoolcon\Model::getId()




---

<a name="getinjectedclass">&nbsp;</a>

### getInjectedClass
```php
UserProfile::getInjectedClass(  $class )
```






* **Inherits** \Phwoolcon\Model::getInjectedClass()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $class | **mixed** | &nbsp; |




---

<a name="getmessages-3">&nbsp;</a>

### getMessages <kbd>magic</kbd>
```php
UserProfile::getMessages( string $filter = null ): array<mixed,\Phalcon\Mvc\Model\Message>
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $filter | **string** | &nbsp; |




---

<a name="getstringmessages">&nbsp;</a>

### getStringMessages
```php
UserProfile::getStringMessages(  )
```






* **Inherits** \Phwoolcon\Model::getStringMessages()




---

<a name="getwriteconnection-3">&nbsp;</a>

### getWriteConnection <kbd>magic</kbd>
```php
UserProfile::getWriteConnection(  ): \Phwoolcon\Db\Adapter\Pdo\Mysql|\Phalcon\Db\Adapter\Pdo
```










---

<a name="initialize-3">&nbsp;</a>

### initialize
```php
UserProfile::initialize(  )
```

Runs once, only when the model instance is created at the first time




* **Overrides** \Phwoolcon\Model::initialize()




---

<a name="isnew">&nbsp;</a>

### isNew
```php
UserProfile::isNew(  )
```






* **Inherits** \Phwoolcon\Model::isNew()




---

<a name="reset-2">&nbsp;</a>

### reset
```php
UserProfile::reset(  )
```






* **Inherits** \Phwoolcon\Model::reset()




---

<a name="setdata">&nbsp;</a>

### setData
```php
UserProfile::setData(  $key,  $value = null )
```






* **Inherits** \Phwoolcon\Model::setData()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setextradata">&nbsp;</a>

### setExtraData
```php
UserProfile::setExtraData(  $key,  $value = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setid">&nbsp;</a>

### setId
```php
UserProfile::setId(  $id )
```






* **Inherits** \Phwoolcon\Model::setId()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $id | **mixed** | &nbsp; |




---

<a name="setrelatedrecord">&nbsp;</a>

### setRelatedRecord
```php
UserProfile::setRelatedRecord(  $key,  $value )
```






* **Inherits** \Phwoolcon\Model::setRelatedRecord()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $value | **mixed** | &nbsp; |




---

<a name="setup">&nbsp;</a>

### setup <kbd>static</kbd>
```php
UserProfile::setup( array $options )
```






* **Inherits** \Phwoolcon\Model::setup()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $options | **array** | &nbsp; |




---

<a name="sqlexecute">&nbsp;</a>

### sqlExecute
```php
UserProfile::sqlExecute(  $sql, null $bind = null ): boolean
```






* **Inherits** \Phwoolcon\Model::sqlExecute()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="sqlfetchall">&nbsp;</a>

### sqlFetchAll
```php
UserProfile::sqlFetchAll(  $sql, null $bind = null ): array
```






* **Inherits** \Phwoolcon\Model::sqlFetchAll()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="sqlfetchcolumn">&nbsp;</a>

### sqlFetchColumn
```php
UserProfile::sqlFetchColumn(  $sql, null $bind = null ): mixed
```






* **Inherits** \Phwoolcon\Model::sqlFetchColumn()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="sqlfetchone">&nbsp;</a>

### sqlFetchOne
```php
UserProfile::sqlFetchOne(  $sql, null $bind = null ): array
```






* **Inherits** \Phwoolcon\Model::sqlFetchOne()

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $sql | **mixed** | &nbsp; |
| $bind | **null** | &nbsp; |




---

<a name="validation">&nbsp;</a>

### validation
```php
UserProfile::validation(  )
```






* **Inherits** \Phwoolcon\Model::validation()




---

<a name="phwoolcon-view">&nbsp;</a>

## Phwoolcon\View




* **Implements**: \Phwoolcon\Daemon\ServiceAwareInterface


<a name="--construct-22">&nbsp;</a>

### __construct
```php
View::__construct(  $config = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $config | **mixed** | &nbsp; |




---

<a name="assets">&nbsp;</a>

### assets <kbd>static</kbd>
```php
View::assets(  $collectionName )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $collectionName | **mixed** | &nbsp; |




---

<a name="clearassetscache">&nbsp;</a>

### clearAssetsCache <kbd>static</kbd>
```php
View::clearAssetsCache(  )
```










---

<a name="generatebodyjs">&nbsp;</a>

### generateBodyJs <kbd>static</kbd>
```php
View::generateBodyJs(  )
```










---

<a name="generateheadcss">&nbsp;</a>

### generateHeadCss <kbd>static</kbd>
```php
View::generateHeadCss(  )
```










---

<a name="generateheadjs">&nbsp;</a>

### generateHeadJs <kbd>static</kbd>
```php
View::generateHeadJs(  )
```










---

<a name="generateiehack">&nbsp;</a>

### generateIeHack <kbd>static</kbd>
```php
View::generateIeHack(  )
```










---

<a name="generateiehackbodyjs">&nbsp;</a>

### generateIeHackBodyJs <kbd>static</kbd>
```php
View::generateIeHackBodyJs(  )
```










---

<a name="getabsoluteviewpath">&nbsp;</a>

### getAbsoluteViewPath
```php
View::getAbsoluteViewPath(  $view )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $view | **mixed** | &nbsp; |




---

<a name="getconfig">&nbsp;</a>

### getConfig <kbd>static</kbd>
```php
View::getConfig(  $key = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |




---

<a name="getcurrenttheme">&nbsp;</a>

### getCurrentTheme
```php
View::getCurrentTheme(  ): mixed
```










---

<a name="getdebugwrapper">&nbsp;</a>

### getDebugWrapper
```php
View::getDebugWrapper(  $viewPath ): array
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $viewPath | **mixed** | &nbsp; |




---

<a name="getpagedescription">&nbsp;</a>

### getPageDescription <kbd>static</kbd>
```php
View::getPageDescription(  )
```










---

<a name="getpagekeywords">&nbsp;</a>

### getPageKeywords <kbd>static</kbd>
```php
View::getPageKeywords(  )
```










---

<a name="getpagelanguage">&nbsp;</a>

### getPageLanguage <kbd>static</kbd>
```php
View::getPageLanguage(  )
```










---

<a name="getpagetitle">&nbsp;</a>

### getPageTitle <kbd>static</kbd>
```php
View::getPageTitle(  )
```










---

<a name="getparam">&nbsp;</a>

### getParam <kbd>static</kbd>
```php
View::getParam(  $key,  $default = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $key | **mixed** | &nbsp; |
| $default | **mixed** | &nbsp; |




---

<a name="getphwoolconjsoptions">&nbsp;</a>

### getPhwoolconJsOptions <kbd>static</kbd>
```php
View::getPhwoolconJsOptions(  )
```










---

<a name="isadmin">&nbsp;</a>

### isAdmin
```php
View::isAdmin(  $flag = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $flag | **mixed** | &nbsp; |




---

<a name="loadassets">&nbsp;</a>

### loadAssets
```php
View::loadAssets(  $assets,  $isAdmin = false )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $assets | **mixed** | &nbsp; |
| $isAdmin | **mixed** | &nbsp; |




---

<a name="make">&nbsp;</a>

### make <kbd>static</kbd>
```php
View::make(  $path,  $file,  $params = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **mixed** | &nbsp; |
| $file | **mixed** | &nbsp; |
| $params | **mixed** | &nbsp; |




---

<a name="nofooter">&nbsp;</a>

### noFooter <kbd>static</kbd>
```php
View::noFooter(  $flag = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $flag | **mixed** | &nbsp; |




---

<a name="noheader">&nbsp;</a>

### noHeader <kbd>static</kbd>
```php
View::noHeader(  $flag = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $flag | **mixed** | &nbsp; |




---

<a name="register-16">&nbsp;</a>

### register <kbd>static</kbd>
```php
View::register( \Phalcon\Di $di )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $di | **\Phalcon\Di** | &nbsp; |




---

<a name="render-1">&nbsp;</a>

### render
```php
View::render(  $controllerName,  $actionName,  $params = null )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $controllerName | **mixed** | &nbsp; |
| $actionName | **mixed** | &nbsp; |
| $params | **mixed** | &nbsp; |




---

<a name="reset-11">&nbsp;</a>

### reset
```php
View::reset(  )
```






* **Implements** \Phwoolcon\Daemon\ServiceAwareInterface::reset()




---

<a name="setcontent">&nbsp;</a>

### setContent
```php
View::setContent(  $content )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $content | **mixed** | &nbsp; |




---

<a name="setparams">&nbsp;</a>

### setParams
```php
View::setParams( array $params )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $params | **array** | &nbsp; |




---

<a name="phwoolcon-view-widget">&nbsp;</a>

## Phwoolcon\View\Widget
Class Widget





<a name="--callstatic-4">&nbsp;</a>

### __callStatic <kbd>static</kbd>
```php
Widget::__callStatic(  $name,  $arguments )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $arguments | **mixed** | &nbsp; |




---

<a name="define">&nbsp;</a>

### define <kbd>static</kbd>
```php
Widget::define(  $name, callable $definition )
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $name | **mixed** | &nbsp; |
| $definition | **callable** | &nbsp; |




---

<a name="idehelpergenerator">&nbsp;</a>

### ideHelperGenerator <kbd>static</kbd>
```php
Widget::ideHelperGenerator(  )
```










---

<a name="label">&nbsp;</a>

### label <kbd>magic</kbd>
```php
Widget::label( array $parameters, string $innerHtml ): string
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $parameters | **array** | &nbsp; |
| $innerHtml | **string** | &nbsp; |




---

<a name="multiplechoose">&nbsp;</a>

### multipleChoose <kbd>magic</kbd>
```php
Widget::multipleChoose( array $parameters ): string
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $parameters | **array** | &nbsp; |




---

<a name="singlechoose">&nbsp;</a>

### singleChoose <kbd>magic</kbd>
```php
Widget::singleChoose( array $parameters ): string
```







**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $parameters | **array** | &nbsp; |




---

<a name="phwoolcon-exception-widgetexception">&nbsp;</a>

## Phwoolcon\Exception\WidgetException







<a name="--">&nbsp;</a>

### __
```php
__( string $string, array|null $params = null, string $package = null ): string
```

Translate




**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $string | **string** | &nbsp; |
| $params | **array&#124;null** | &nbsp; |
| $package | **string** | &nbsp; |




---

<a name="-e">&nbsp;</a>

### _e
```php
_e(  $string,  $newLineToBr = true )
```






**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $string | **mixed** | &nbsp; |
| $newLineToBr | **mixed** | &nbsp; |




---

<a name="array-forget">&nbsp;</a>

### array_forget
```php
array_forget( array &$array, string $key, string $separator = '.' ): void
```

Remove an array item from a given array using "dot" notation.




**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $array | **array** | &nbsp; |
| $key | **string** | &nbsp; |
| $separator | **string** | &nbsp; |




---

<a name="array-set">&nbsp;</a>

### array_set
```php
array_set( array &$array, string $key, mixed $value, string $separator = '.' ): array
```

Set an array item to a given value using "dot" notation.

If no key is given to the method, the entire array will be replaced.


**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $array | **array** | &nbsp; |
| $key | **string** | &nbsp; |
| $value | **mixed** | &nbsp; |
| $separator | **string** | &nbsp; |




---

<a name="arraysortedmerge">&nbsp;</a>

### arraySortedMerge
```php
arraySortedMerge( array $array ): array
```

Return sorted and merged result of a given array, which contains sort orders as top level keys.

Values with smaller sort order will be overridden by bigger ones.

Example:

```php
 $array = [
     10 => [                 // 10 is a sort order
         'foo' => 'bar',     // Holds value 'bar' in key 'foo'
         'who' => 'me',
     ],
     20 => [                 // 20 is a bigger sort order
         'foo' => 'baz',     // This will override the key 'foo' with value 'baz'
         'hello' => 'world', // New values will be merged
     ],
 ];
 var_export($result = arraySortedMerge($array));
```

Will produce:

```php
 $result = [
     'foo' => 'baz',
     'who' => 'me',
     'hello' => 'world',
 ];
```


**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $array | **array** | &nbsp; |




---

<a name="base62encode">&nbsp;</a>

### base62encode
```php
base62encode( mixed $val ): string
```

Convert a decimal number into base62 string




**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $val | **mixed** | Decimal value |


**Return Value:**

Base 62 value



---

<a name="copydirmerge">&nbsp;</a>

### copyDirMerge
```php
copyDirMerge( string $source, string $destination )
```

Copy dir, keep destination files, if exists




**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $source | **string** | &nbsp; |
| $destination | **string** | &nbsp; |




---

<a name="copydiroverride">&nbsp;</a>

### copyDirOverride
```php
copyDirOverride( string $source, string $destination )
```

Copy dir, override destination files, if exists




**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $source | **string** | &nbsp; |
| $destination | **string** | &nbsp; |




---

<a name="copydirreplace">&nbsp;</a>

### copyDirReplace
```php
copyDirReplace( string $source, string $destination )
```

Copy dir, delete entire destination dir first, if exists




**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $source | **string** | &nbsp; |
| $destination | **string** | &nbsp; |




---

<a name="filesavearray">&nbsp;</a>

### fileSaveArray
```php
fileSaveArray( string $filename, mixed $array, callable $filter = null ): integer
```






**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $filename | **string** | &nbsp; |
| $array | **mixed** | &nbsp; |
| $filter | **callable** | &nbsp; |




---

<a name="filesaveinclude">&nbsp;</a>

### fileSaveInclude
```php
fileSaveInclude(  $target, array $includes )
```






**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $target | **mixed** | &nbsp; |
| $includes | **array** | &nbsp; |




---

<a name="fnget">&nbsp;</a>

### fnGet
```php
fnGet( array|object &$array, string $key, mixed $default = null, string $separator = '.', boolean $hasObject = false ): mixed
```

Safely get child value from an array or an object

Usage:

Assume you want to get value from a multidimensional array like: <code>$array = ['l1' => ['l2' => 'value']]</code>,<br>
then you can try following:


```php
$l1 = fnGet($array, 'l1'); // returns ['l2' => 'value']
$l2 = fnGet($array, 'l1.l2'); // returns 'value'
$undefined = fnGet($array, 'l3'); // returns null
```

You can specify default value for undefined keys, and the key separator:


```php
$l2 = fnGet($array, 'l1/l2', null, '/'); // returns 'value'
$undefined = fnGet($array, 'l3', 'default value'); // returns 'default value'
```


**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $array | **array&#124;object** | Subject array or object |
| $key | **string** | Indicates the data element of the target value |
| $default | **mixed** | Default value if key not found in subject |
| $separator | **string** | Key level separator, default '.' |
| $hasObject | **boolean** | Indicates that the subject may contains object, default false |




---

<a name="getrelativepath">&nbsp;</a>

### getRelativePath
```php
getRelativePath( string $source, string $destination ): string
```

Return a relative path for destination relative to source




**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $source | **string** | &nbsp; |
| $destination | **string** | &nbsp; |




---

<a name="ishttpurl">&nbsp;</a>

### isHttpUrl
```php
isHttpUrl(  $url )
```






**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $url | **mixed** | &nbsp; |




---

<a name="migrationpath">&nbsp;</a>

### migrationPath
```php
migrationPath(  $path = null )
```






**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **mixed** | &nbsp; |




---

<a name="opcache-invalidate">&nbsp;</a>

### opcache_invalidate
```php
opcache_invalidate( string $script, boolean $force = false ): boolean
```

(PHP 5 &gt;= 5.5.0, PECL ZendOpcache &gt;= 7.0.0 )<br/>
Invalidates a cached script




**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $script | **string** | <p>The path to the script being invalidated.</p> |
| $force | **boolean** | [optional] <p> If set to <b>TRUE</b>, the script will be invalidated
                   regardless of whether invalidation is necessary.</p> |


**Return Value:**

Returns <b>TRUE</b> if the opcode cache for <em>script</em> was
invalidated or if there was nothing to invalidate, or <b>FALSE</b> if the opcode
cache is disabled.


**See Also:**

* http://www.php.net/manual/en/function.opcache-invalidate.php 

---

<a name="opcache-reset">&nbsp;</a>

### opcache_reset
```php
opcache_reset(  ): boolean
```

(PHP 5 &gt;= 5.5.0, PECL ZendOpcache &gt;= 7.0.0 )<br/>
Resets the contents of the opcode cache





**Return Value:**

Returns <b>TRUE</b> if the opcode cache was reset, or <b>FALSE</b> if the opcode cache is disabled.


**See Also:**

* http://www.php.net/manual/en/function.opcache-reset.php 

---

<a name="price">&nbsp;</a>

### price
```php
price(  $amount,  $currency = 'CNY' )
```






**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $amount | **mixed** | &nbsp; |
| $currency | **mixed** | &nbsp; |




---

<a name="random-bytes">&nbsp;</a>

### random_bytes
```php
random_bytes(  $length )
```






**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $length | **mixed** | &nbsp; |




---

<a name="removedir">&nbsp;</a>

### removeDir
```php
removeDir(  $dir )
```






**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $dir | **mixed** | &nbsp; |




---

<a name="secureurl">&nbsp;</a>

### secureUrl
```php
secureUrl(  $path, array $queries = array() )
```






**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **mixed** | &nbsp; |
| $queries | **array** | &nbsp; |




---

<a name="showtrace">&nbsp;</a>

### showTrace
```php
showTrace( boolean $exit = true, boolean $print = true ): string
```

Show execution trace for debugging




**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $exit | **boolean** | Set to true to exit after show trace. |
| $print | **boolean** | Set to true to print trace |




---

<a name="storagepath">&nbsp;</a>

### storagePath
```php
storagePath(  $path = null )
```






**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **mixed** | &nbsp; |




---

<a name="symlinkdiroverride">&nbsp;</a>

### symlinkDirOverride
```php
symlinkDirOverride( string $source, string $destination )
```

Copy dir by symlink files, override destination files, if exists




**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $source | **string** | &nbsp; |
| $destination | **string** | &nbsp; |




---

<a name="symlinkrelative">&nbsp;</a>

### symlinkRelative
```php
symlinkRelative( string $source, string $destination ): boolean
```

Creates a symlink with relative path to source
On Windows, the file will be copied instead of symlink




**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $source | **string** | &nbsp; |
| $destination | **string** | &nbsp; |




---

<a name="url">&nbsp;</a>

### url
```php
url(  $path, array $queries = array(),  $secure = null )
```






**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| $path | **mixed** | &nbsp; |
| $queries | **array** | &nbsp; |
| $secure | **mixed** | &nbsp; |




---



> This document was automatically generated from source code comments on 2016-12-23<br>
> Generated by:<br>
> [phpDocumentor](http://www.phpdoc.org/)<br>
> [phwoolcon/phpdoc-markdown-public](https://github.com/phwoolcon/phpdoc-markdown-public) (Variant of [cvuorinen/phpdoc-markdown-public](https://github.com/cvuorinen/phpdoc-markdown-public))<br>
