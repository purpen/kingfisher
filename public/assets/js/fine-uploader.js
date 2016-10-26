<<<<<<< HEAD
!function(global){var qq=function(e){"use strict";return{hide:function(){return e.style.display="none",this},attach:function(t,n){return e.addEventListener?e.addEventListener(t,n,!1):e.attachEvent&&e.attachEvent("on"+t,n),function(){qq(e).detach(t,n)}},detach:function(t,n){return e.removeEventListener?e.removeEventListener(t,n,!1):e.attachEvent&&e.detachEvent("on"+t,n),this},contains:function(t){return!!t&&(e===t||(e.contains?e.contains(t):!!(8&t.compareDocumentPosition(e))))},insertBefore:function(t){return t.parentNode.insertBefore(e,t),this},remove:function(){return e.parentNode.removeChild(e),this},css:function(t){if(null==e.style)throw new qq.Error("Can't apply style to node as it is not on the HTMLElement prototype chain!");return null!=t.opacity&&"string"!=typeof e.style.opacity&&"undefined"!=typeof e.filters&&(t.filter="alpha(opacity="+Math.round(100*t.opacity)+")"),qq.extend(e.style,t),this},hasClass:function(t,n){var i=new RegExp("(^| )"+t+"( |$)");return i.test(e.className)||!(!n||!i.test(e.parentNode.className))},addClass:function(t){return qq(e).hasClass(t)||(e.className+=" "+t),this},removeClass:function(t){var n=new RegExp("(^| )"+t+"( |$)");return e.className=e.className.replace(n," ").replace(/^\s+|\s+$/g,""),this},getByClass:function(t,n){var i,o=[];return n&&e.querySelector?e.querySelector("."+t):e.querySelectorAll?e.querySelectorAll("."+t):(i=e.getElementsByTagName("*"),qq.each(i,function(e,n){qq(n).hasClass(t)&&o.push(n)}),n?o[0]:o)},getFirstByClass:function(t){return qq(e).getByClass(t,!0)},children:function(){for(var t=[],n=e.firstChild;n;)1===n.nodeType&&t.push(n),n=n.nextSibling;return t},setText:function(t){return e.innerText=t,e.textContent=t,this},clearText:function(){return qq(e).setText("")},hasAttribute:function(t){var n;return e.hasAttribute?!!e.hasAttribute(t)&&null==/^false$/i.exec(e.getAttribute(t)):(n=e[t],void 0!==n&&null==/^false$/i.exec(n))}}};!function(){"use strict";qq.canvasToBlob=function(e,t,n){return qq.dataUriToBlob(e.toDataURL(t,n))},qq.dataUriToBlob=function(e){var t,n,i,o,r=function(e,t){var n=window.BlobBuilder||window.WebKitBlobBuilder||window.MozBlobBuilder||window.MSBlobBuilder,i=n&&new n;return i?(i.append(e),i.getBlob(t)):new Blob([e],{type:t})};return n=e.split(",")[0].indexOf("base64")>=0?atob(e.split(",")[1]):decodeURI(e.split(",")[1]),o=e.split(",")[0].split(":")[1].split(";")[0],t=new ArrayBuffer(n.length),i=new Uint8Array(t),qq.each(n,function(e,t){i[e]=t.charCodeAt(0)}),r(t,o)},qq.log=function(e,t){window.console&&(t&&"info"!==t?window.console[t]?window.console[t](e):window.console.log("<"+t+"> "+e):window.console.log(e))},qq.isObject=function(e){return e&&!e.nodeType&&"[object Object]"===Object.prototype.toString.call(e)},qq.isFunction=function(e){return"function"==typeof e},qq.isArray=function(e){return"[object Array]"===Object.prototype.toString.call(e)||e&&window.ArrayBuffer&&e.buffer&&e.buffer.constructor===ArrayBuffer},qq.isItemList=function(e){return"[object DataTransferItemList]"===Object.prototype.toString.call(e)},qq.isNodeList=function(e){return"[object NodeList]"===Object.prototype.toString.call(e)||e.item&&e.namedItem},qq.isString=function(e){return"[object String]"===Object.prototype.toString.call(e)},qq.trimStr=function(e){return String.prototype.trim?e.trim():e.replace(/^\s+|\s+$/g,"")},qq.format=function(e){var t=Array.prototype.slice.call(arguments,1),n=e,i=n.indexOf("{}");return qq.each(t,function(e,t){var o=n.substring(0,i),r=n.substring(i+2);if(n=o+t+r,i=n.indexOf("{}",i+t.length),i<0)return!1}),n},qq.isFile=function(e){return window.File&&"[object File]"===Object.prototype.toString.call(e)},qq.isFileList=function(e){return window.FileList&&"[object FileList]"===Object.prototype.toString.call(e)},qq.isFileOrInput=function(e){return qq.isFile(e)||qq.isInput(e)},qq.isInput=function(e,t){var n=function(e){var n=e.toLowerCase();return t?"file"!==n:"file"===n};return!!(window.HTMLInputElement&&"[object HTMLInputElement]"===Object.prototype.toString.call(e)&&e.type&&n(e.type))||!!(e.tagName&&"input"===e.tagName.toLowerCase()&&e.type&&n(e.type))},qq.isBlob=function(e){if(window.Blob&&"[object Blob]"===Object.prototype.toString.call(e))return!0},qq.isXhrUploadSupported=function(){var e=document.createElement("input");return e.type="file",void 0!==e.multiple&&"undefined"!=typeof File&&"undefined"!=typeof FormData&&"undefined"!=typeof qq.createXhrInstance().upload},qq.createXhrInstance=function(){if(window.XMLHttpRequest)return new XMLHttpRequest;try{return new ActiveXObject("MSXML2.XMLHTTP.3.0")}catch(e){return qq.log("Neither XHR or ActiveX are supported!","error"),null}},qq.isFolderDropSupported=function(e){return e.items&&e.items.length>0&&e.items[0].webkitGetAsEntry},qq.isFileChunkingSupported=function(){return!qq.androidStock()&&qq.isXhrUploadSupported()&&(void 0!==File.prototype.slice||void 0!==File.prototype.webkitSlice||void 0!==File.prototype.mozSlice)},qq.sliceBlob=function(e,t,n){var i=e.slice||e.mozSlice||e.webkitSlice;return i.call(e,t,n)},qq.arrayBufferToHex=function(e){var t="",n=new Uint8Array(e);return qq.each(n,function(e,n){var i=n.toString(16);i.length<2&&(i="0"+i),t+=i}),t},qq.readBlobToHex=function(e,t,n){var i=qq.sliceBlob(e,t,t+n),o=new FileReader,r=new qq.Promise;return o.onload=function(){r.success(qq.arrayBufferToHex(o.result))},o.onerror=r.failure,o.readAsArrayBuffer(i),r},qq.extend=function(e,t,n){return qq.each(t,function(t,i){n&&qq.isObject(i)?(void 0===e[t]&&(e[t]={}),qq.extend(e[t],i,!0)):e[t]=i}),e},qq.override=function(e,t){var n={},i=t(n);return qq.each(i,function(t,i){void 0!==e[t]&&(n[t]=e[t]),e[t]=i}),e},qq.indexOf=function(e,t,n){if(e.indexOf)return e.indexOf(t,n);n=n||0;var i=e.length;for(n<0&&(n+=i);n<i;n+=1)if(e.hasOwnProperty(n)&&e[n]===t)return n;return-1},qq.getUniqueId=function(){return"xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g,function(e){var t=16*Math.random()|0,n="x"==e?t:3&t|8;return n.toString(16)})},qq.ie=function(){return navigator.userAgent.indexOf("MSIE")!==-1||navigator.userAgent.indexOf("Trident")!==-1},qq.ie7=function(){return navigator.userAgent.indexOf("MSIE 7")!==-1},qq.ie8=function(){return navigator.userAgent.indexOf("MSIE 8")!==-1},qq.ie10=function(){return navigator.userAgent.indexOf("MSIE 10")!==-1},qq.ie11=function(){return qq.ie()&&navigator.userAgent.indexOf("rv:11")!==-1},qq.edge=function(){return navigator.userAgent.indexOf("Edge")>=0},qq.safari=function(){return void 0!==navigator.vendor&&navigator.vendor.indexOf("Apple")!==-1},qq.chrome=function(){return void 0!==navigator.vendor&&navigator.vendor.indexOf("Google")!==-1},qq.opera=function(){return void 0!==navigator.vendor&&navigator.vendor.indexOf("Opera")!==-1},qq.firefox=function(){return!qq.edge()&&!qq.ie11()&&navigator.userAgent.indexOf("Mozilla")!==-1&&void 0!==navigator.vendor&&""===navigator.vendor},qq.windows=function(){return"Win32"===navigator.platform},qq.android=function(){return navigator.userAgent.toLowerCase().indexOf("android")!==-1},qq.androidStock=function(){return qq.android()&&navigator.userAgent.toLowerCase().indexOf("chrome")<0},qq.ios6=function(){return qq.ios()&&navigator.userAgent.indexOf(" OS 6_")!==-1},qq.ios7=function(){return qq.ios()&&navigator.userAgent.indexOf(" OS 7_")!==-1},qq.ios8=function(){return qq.ios()&&navigator.userAgent.indexOf(" OS 8_")!==-1},qq.ios800=function(){return qq.ios()&&navigator.userAgent.indexOf(" OS 8_0 ")!==-1},qq.ios=function(){return navigator.userAgent.indexOf("iPad")!==-1||navigator.userAgent.indexOf("iPod")!==-1||navigator.userAgent.indexOf("iPhone")!==-1},qq.iosChrome=function(){return qq.ios()&&navigator.userAgent.indexOf("CriOS")!==-1},qq.iosSafari=function(){return qq.ios()&&!qq.iosChrome()&&navigator.userAgent.indexOf("Safari")!==-1},qq.iosSafariWebView=function(){return qq.ios()&&!qq.iosChrome()&&!qq.iosSafari()},qq.preventDefault=function(e){e.preventDefault?e.preventDefault():e.returnValue=!1},qq.toElement=function(){var e=document.createElement("div");return function(t){e.innerHTML=t;var n=e.firstChild;return e.removeChild(n),n}}(),qq.each=function(e,t){var n,i;if(e)if(window.Storage&&e.constructor===window.Storage)for(n=0;n<e.length&&(i=t(e.key(n),e.getItem(e.key(n))),i!==!1);n++);else if(qq.isArray(e)||qq.isItemList(e)||qq.isNodeList(e))for(n=0;n<e.length&&(i=t(n,e[n]),i!==!1);n++);else if(qq.isString(e))for(n=0;n<e.length&&(i=t(n,e.charAt(n)),i!==!1);n++);else for(n in e)if(Object.prototype.hasOwnProperty.call(e,n)&&(i=t(n,e[n]),i===!1))break},qq.bind=function(e,t){if(qq.isFunction(e)){var n=Array.prototype.slice.call(arguments,2);return function(){var i=qq.extend([],n);return arguments.length&&(i=i.concat(Array.prototype.slice.call(arguments))),e.apply(t,i)}}throw new Error("first parameter must be a function!")},qq.obj2url=function(e,t,n){var i=[],o="&",r=function(e,n){var o=t?/\[\]$/.test(t)?t:t+"["+n+"]":n;"undefined"!==o&&"undefined"!==n&&i.push("object"==typeof e?qq.obj2url(e,o,!0):"[object Function]"===Object.prototype.toString.call(e)?encodeURIComponent(o)+"="+encodeURIComponent(e()):encodeURIComponent(o)+"="+encodeURIComponent(e))};return!n&&t?(o=/\?/.test(t)?/\?$/.test(t)?"":"&":"?",i.push(t),i.push(qq.obj2url(e))):"[object Array]"===Object.prototype.toString.call(e)&&"undefined"!=typeof e?qq.each(e,function(e,t){r(t,e)}):"undefined"!=typeof e&&null!==e&&"object"==typeof e?qq.each(e,function(e,t){r(t,e)}):i.push(encodeURIComponent(t)+"="+encodeURIComponent(e)),t?i.join(o):i.join(o).replace(/^&/,"").replace(/%20/g,"+")},qq.obj2FormData=function(e,t,n){return t||(t=new FormData),qq.each(e,function(e,i){e=n?n+"["+e+"]":e,qq.isObject(i)?qq.obj2FormData(i,t,e):qq.isFunction(i)?t.append(e,i()):t.append(e,i)}),t},qq.obj2Inputs=function(e,t){var n;return t||(t=document.createElement("form")),qq.obj2FormData(e,{append:function(e,i){n=document.createElement("input"),n.setAttribute("name",e),n.setAttribute("value",i),t.appendChild(n)}}),t},qq.parseJson=function(json){return window.JSON&&qq.isFunction(JSON.parse)?JSON.parse(json):eval("("+json+")")},qq.getExtension=function(e){var t=e.lastIndexOf(".")+1;if(t>0)return e.substr(t,e.length-t)},qq.getFilename=function(e){return qq.isInput(e)?e.value.replace(/.*(\/|\\)/,""):qq.isFile(e)&&null!==e.fileName&&void 0!==e.fileName?e.fileName:e.name},qq.DisposeSupport=function(){var e=[];return{dispose:function(){var t;do t=e.shift(),t&&t();while(t)},attach:function(){var e=arguments;this.addDisposer(qq(e[0]).attach.apply(this,Array.prototype.slice.call(arguments,1)))},addDisposer:function(t){e.push(t)}}}}(),function(){"use strict";qq.Error=function(e){this.message="[Fine Uploader "+qq.version+"] "+e},qq.Error.prototype=new Error}(),qq.version="5.10.0",qq.supportedFeatures=function(){"use strict";function e(){var e,t=!0;try{e=document.createElement("input"),e.type="file",qq(e).hide(),e.disabled&&(t=!1)}catch(n){t=!1}return t}function t(){return(qq.chrome()||qq.opera())&&void 0!==navigator.userAgent.match(/Chrome\/[2][1-9]|Chrome\/[3-9][0-9]/)}function n(){return(qq.chrome()||qq.opera())&&void 0!==navigator.userAgent.match(/Chrome\/[1][4-9]|Chrome\/[2-9][0-9]/)}function i(){if(window.XMLHttpRequest){var e=qq.createXhrInstance();return void 0!==e.withCredentials}return!1}function o(){return void 0!==window.XDomainRequest}function r(){return!!i()||o()}function a(){return void 0!==document.createElement("input").webkitdirectory}function s(){try{return!!window.localStorage&&qq.isFunction(window.localStorage.setItem)}catch(e){return!1}}function l(){var e=document.createElement("span");return("draggable"in e||"ondragstart"in e&&"ondrop"in e)&&!qq.android()&&!qq.ios()}var u,c,d,p,h,q,f,m,g,_,v,b,y,S,w;return u=e(),p=u&&qq.isXhrUploadSupported(),c=p&&!qq.androidStock(),d=p&&l(),h=d&&t(),q=p&&qq.isFileChunkingSupported(),f=p&&q&&s(),m=p&&n(),g=u&&(void 0!==window.postMessage||p),v=i(),_=o(),b=r(),y=a(),S=p&&void 0!==window.FileReader,w=function(){return!!p&&(!qq.androidStock()&&!qq.iosChrome())}(),{ajaxUploading:p,blobUploading:c,canDetermineSize:p,chunking:q,deleteFileCors:b,deleteFileCorsXdr:_,deleteFileCorsXhr:v,dialogElement:!!window.HTMLDialogElement,fileDrop:d,folderDrop:h,folderSelection:y,imagePreviews:S,imageValidation:S,itemSizeValidation:p,pause:q,progressBar:w,resume:f,scaling:S&&c,tiffPreviews:qq.safari(),unlimitedScaledImageSize:!qq.ios(),uploading:u,uploadCors:g,uploadCustomHeaders:p,uploadNonMultipart:p,uploadViaPaste:m}}(),qq.isGenericPromise=function(e){"use strict";return!!(e&&e.then&&qq.isFunction(e.then))},qq.Promise=function(){"use strict";var e,t,n=[],i=[],o=[],r=0;qq.extend(this,{then:function(o,a){return 0===r?(o&&n.push(o),a&&i.push(a)):r===-1?a&&a.apply(null,t):o&&o.apply(null,e),this},done:function(n){return 0===r?o.push(n):n.apply(null,void 0===t?e:t),this},success:function(){return r=1,e=arguments,n.length&&qq.each(n,function(t,n){n.apply(null,e)}),o.length&&qq.each(o,function(t,n){n.apply(null,e)}),this},failure:function(){return r=-1,t=arguments,i.length&&qq.each(i,function(e,n){n.apply(null,t)}),o.length&&qq.each(o,function(e,n){n.apply(null,t)}),this}})},qq.BlobProxy=function(e,t){"use strict";qq.extend(this,{referenceBlob:e,create:function(){return t(e)}})},qq.UploadButton=function(e){"use strict";function t(){var e=document.createElement("input");return e.setAttribute(qq.UploadButton.BUTTON_ID_ATTR_NAME,i),e.setAttribute("title",a.title),o.setMultiple(a.multiple,e),a.folders&&qq.supportedFeatures.folderSelection&&e.setAttribute("webkitdirectory",""),a.acceptFiles&&e.setAttribute("accept",a.acceptFiles),e.setAttribute("type","file"),e.setAttribute("name",a.name),qq(e).css({position:"absolute",right:0,top:0,fontFamily:"Arial",fontSize:qq.ie()&&!qq.ie8()?"3500px":"118px",margin:0,padding:0,cursor:"pointer",opacity:0}),!qq.ie7()&&qq(e).css({height:"100%"}),a.element.appendChild(e),r.attach(e,"change",function(){a.onChange(e)}),r.attach(e,"mouseover",function(){qq(a.element).addClass(a.hoverClass)}),r.attach(e,"mouseout",function(){qq(a.element).removeClass(a.hoverClass)}),r.attach(e,"focus",function(){qq(a.element).addClass(a.focusClass)}),r.attach(e,"blur",function(){qq(a.element).removeClass(a.focusClass)}),e}var n,i,o=this,r=new qq.DisposeSupport,a={acceptFiles:null,element:null,focusClass:"qq-upload-button-focus",folders:!1,hoverClass:"qq-upload-button-hover",ios8BrowserCrashWorkaround:!1,multiple:!1,name:"qqfile",onChange:function(e){},title:null};qq.extend(a,e),i=qq.getUniqueId(),qq(a.element).css({position:"relative",overflow:"hidden",direction:"ltr"}),qq.extend(this,{getInput:function(){return n},getButtonId:function(){return i},setMultiple:function(e,t){var n=t||this.getInput();a.ios8BrowserCrashWorkaround&&qq.ios8()&&(qq.iosChrome()||qq.iosSafariWebView())?n.setAttribute("multiple",""):e?n.setAttribute("multiple",""):n.removeAttribute("multiple")},setAcceptFiles:function(e){e!==a.acceptFiles&&n.setAttribute("accept",e)},reset:function(){n.parentNode&&qq(n).remove(),qq(a.element).removeClass(a.focusClass),n=null,n=t()}}),n=t()},qq.UploadButton.BUTTON_ID_ATTR_NAME="qq-button-id",qq.UploadData=function(e){"use strict";function t(e){if(qq.isArray(e)){var t=[];return qq.each(e,function(e,n){t.push(o[n])}),t}return o[e]}function n(e){if(qq.isArray(e)){var t=[];return qq.each(e,function(e,n){t.push(o[r[n]])}),t}return o[r[e]]}function i(e){var t=[],n=[].concat(e);return qq.each(n,function(e,n){var i=a[n];void 0!==i&&qq.each(i,function(e,n){t.push(o[n])})}),t}var o=[],r={},a={},s={},l={};qq.extend(this,{addFile:function(t){var n=t.status||qq.status.SUBMITTING,i=o.push({name:t.name,originalName:t.name,uuid:t.uuid,size:null==t.size?-1:t.size,status:n})-1;return t.batchId&&(o[i].batchId=t.batchId,void 0===l[t.batchId]&&(l[t.batchId]=[]),l[t.batchId].push(i)),t.proxyGroupId&&(o[i].proxyGroupId=t.proxyGroupId,void 0===s[t.proxyGroupId]&&(s[t.proxyGroupId]=[]),s[t.proxyGroupId].push(i)),o[i].id=i,r[t.uuid]=i,void 0===a[n]&&(a[n]=[]),a[n].push(i),e.onStatusChange(i,null,n),i},retrieve:function(e){return qq.isObject(e)&&o.length?void 0!==e.id?t(e.id):void 0!==e.uuid?n(e.uuid):e.status?i(e.status):void 0:qq.extend([],o,!0)},reset:function(){o=[],r={},a={},l={}},setStatus:function(t,n){var i=o[t].status,r=qq.indexOf(a[i],t);a[i].splice(r,1),o[t].status=n,void 0===a[n]&&(a[n]=[]),a[n].push(t),e.onStatusChange(t,i,n)},uuidChanged:function(e,t){var n=o[e].uuid;o[e].uuid=t,r[t]=e,delete r[n]},updateName:function(e,t){o[e].name=t},updateSize:function(e,t){o[e].size=t},setParentId:function(e,t){o[e].parentId=t},getIdsInProxyGroup:function(e){var t=o[e].proxyGroupId;return t?s[t]:[]},getIdsInBatch:function(e){var t=o[e].batchId;return l[t]}})},qq.status={SUBMITTING:"submitting",SUBMITTED:"submitted",REJECTED:"rejected",QUEUED:"queued",CANCELED:"canceled",PAUSED:"paused",UPLOADING:"uploading",UPLOAD_RETRYING:"retrying upload",UPLOAD_SUCCESSFUL:"upload successful",UPLOAD_FAILED:"upload failed",DELETE_FAILED:"delete failed",DELETING:"deleting",DELETED:"deleted"},function(){"use strict";qq.basePublicApi={addBlobs:function(e,t,n){this.addFiles(e,t,n)},addInitialFiles:function(e){var t=this;qq.each(e,function(e,n){t._addCannedFile(n)})},addFiles:function(e,t,n){this._maybeHandleIos8SafariWorkaround();var i=0===this._storedIds.length?qq.getUniqueId():this._currentBatchId,o=qq.bind(function(e){this._handleNewFile({blob:e,name:this._options.blobs.defaultName},i,d)},this),r=qq.bind(function(e){this._handleNewFile(e,i,d)},this),a=qq.bind(function(e){var t=qq.canvasToBlob(e);this._handleNewFile({blob:t,name:this._options.blobs.defaultName+".png"},i,d)},this),s=qq.bind(function(e){var t=e.quality&&e.quality/100,n=qq.canvasToBlob(e.canvas,e.type,t);this._handleNewFile({blob:n,name:e.name},i,d)},this),l=qq.bind(function(e){if(qq.isInput(e)&&qq.supportedFeatures.ajaxUploading){var t=Array.prototype.slice.call(e.files),n=this;qq.each(t,function(e,t){n._handleNewFile(t,i,d)})}else this._handleNewFile(e,i,d)},this),u=function(){qq.isFileList(e)&&(e=Array.prototype.slice.call(e)),e=[].concat(e)},c=this,d=[];this._currentBatchId=i,e&&(u(),qq.each(e,function(e,t){qq.isFileOrInput(t)?l(t):qq.isBlob(t)?o(t):qq.isObject(t)?t.blob&&t.name?r(t):t.canvas&&t.name&&s(t):t.tagName&&"canvas"===t.tagName.toLowerCase()?a(t):c.log(t+" is not a valid file container!  Ignoring!","warn")}),this.log("Received "+d.length+" files."),this._prepareItemsForUpload(d,t,n))},cancel:function(e){this._handler.cancel(e)},cancelAll:function(){var e=[],t=this;qq.extend(e,this._storedIds),qq.each(e,function(e,n){t.cancel(n)}),this._handler.cancelAll()},clearStoredFiles:function(){this._storedIds=[]},continueUpload:function(e){var t=this._uploadData.retrieve({id:e});return!(!qq.supportedFeatures.pause||!this._options.chunking.enabled)&&(t.status===qq.status.PAUSED?(this.log(qq.format("Paused file ID {} ({}) will be continued.  Not paused.",e,this.getName(e))),this._uploadFile(e),!0):(this.log(qq.format("Ignoring continue for file ID {} ({}).  Not paused.",e,this.getName(e)),"error"),!1))},deleteFile:function(e){return this._onSubmitDelete(e)},doesExist:function(e){return this._handler.isValid(e)},drawThumbnail:function(e,t,n,i,o){var r,a,s=new qq.Promise;return this._imageGenerator?(r=this._thumbnailUrls[e],a={customResizeFunction:o,maxSize:n>0?n:null,scale:n>0},!i&&qq.supportedFeatures.imagePreviews&&(r=this.getFile(e)),null==r?s.failure({container:t,error:"File or URL not found."}):this._imageGenerator.generate(r,t,a).then(function(e){s.success(e)},function(e,t){s.failure({container:e,error:t||"Problem generating thumbnail"})})):s.failure({container:t,error:"Missing image generator module"}),s},getButton:function(e){return this._getButton(this._buttonIdsForFileIds[e])},getEndpoint:function(e){return this._endpointStore.get(e)},getFile:function(e){return this._handler.getFile(e)||null},getInProgress:function(){return this._uploadData.retrieve({status:[qq.status.UPLOADING,qq.status.UPLOAD_RETRYING,qq.status.QUEUED]}).length},getName:function(e){return this._uploadData.retrieve({id:e}).name},getParentId:function(e){var t=this.getUploads({id:e}),n=null;return t&&void 0!==t.parentId&&(n=t.parentId),n},getResumableFilesData:function(){return this._handler.getResumableFilesData()},getSize:function(e){return this._uploadData.retrieve({id:e}).size},getNetUploads:function(){return this._netUploaded},getRemainingAllowedItems:function(){var e=this._currentItemLimit;return e>0?e-this._netUploadedOrQueued:null},getUploads:function(e){return this._uploadData.retrieve(e)},getUuid:function(e){return this._uploadData.retrieve({id:e}).uuid},log:function(e,t){!this._options.debug||t&&"info"!==t?t&&"info"!==t&&qq.log("[Fine Uploader "+qq.version+"] "+e,t):qq.log("[Fine Uploader "+qq.version+"] "+e)},pauseUpload:function(e){var t=this._uploadData.retrieve({id:e});if(!qq.supportedFeatures.pause||!this._options.chunking.enabled)return!1;if(qq.indexOf([qq.status.UPLOADING,qq.status.UPLOAD_RETRYING],t.status)>=0){if(this._handler.pause(e))return this._uploadData.setStatus(e,qq.status.PAUSED),!0;this.log(qq.format("Unable to pause file ID {} ({}).",e,this.getName(e)),"error")}else this.log(qq.format("Ignoring pause for file ID {} ({}).  Not in progress.",e,this.getName(e)),"error");return!1},reset:function(){this.log("Resetting uploader..."),this._handler.reset(),this._storedIds=[],this._autoRetries=[],this._retryTimeouts=[],this._preventRetries=[],this._thumbnailUrls=[],qq.each(this._buttons,function(e,t){t.reset()}),this._paramsStore.reset(),this._endpointStore.reset(),this._netUploadedOrQueued=0,this._netUploaded=0,this._uploadData.reset(),this._buttonIdsForFileIds=[],this._pasteHandler&&this._pasteHandler.reset(),this._options.session.refreshOnReset&&this._refreshSessionData(),this._succeededSinceLastAllComplete=[],this._failedSinceLastAllComplete=[],this._totalProgress&&this._totalProgress.reset()},retry:function(e){return this._manualRetry(e)},scaleImage:function(e,t){var n=this;return qq.Scaler.prototype.scaleImage(e,t,{log:qq.bind(n.log,n),getFile:qq.bind(n.getFile,n),uploadData:n._uploadData})},setCustomHeaders:function(e,t){this._customHeadersStore.set(e,t)},setDeleteFileCustomHeaders:function(e,t){this._deleteFileCustomHeadersStore.set(e,t)},setDeleteFileEndpoint:function(e,t){this._deleteFileEndpointStore.set(e,t)},setDeleteFileParams:function(e,t){this._deleteFileParamsStore.set(e,t)},setEndpoint:function(e,t){this._endpointStore.set(e,t)},setForm:function(e){this._updateFormSupportAndParams(e)},setItemLimit:function(e){this._currentItemLimit=e},setName:function(e,t){this._uploadData.updateName(e,t)},setParams:function(e,t){this._paramsStore.set(e,t)},setUuid:function(e,t){return this._uploadData.uuidChanged(e,t)},uploadStoredFiles:function(){0===this._storedIds.length?this._itemError("noFilesError"):this._uploadStoredFiles()}},qq.basePrivateApi={_addCannedFile:function(e){var t=this._uploadData.addFile({uuid:e.uuid,name:e.name,size:e.size,status:qq.status.UPLOAD_SUCCESSFUL});return e.deleteFileEndpoint&&this.setDeleteFileEndpoint(e.deleteFileEndpoint,t),e.deleteFileParams&&this.setDeleteFileParams(e.deleteFileParams,t),e.thumbnailUrl&&(this._thumbnailUrls[t]=e.thumbnailUrl),this._netUploaded++,this._netUploadedOrQueued++,t},_annotateWithButtonId:function(e,t){qq.isFile(e)&&(e.qqButtonId=this._getButtonId(t))},_batchError:function(e){this._options.callbacks.onError(null,null,e,void 0)},_createDeleteHandler:function(){var e=this;return new qq.DeleteFileAjaxRequester({method:this._options.deleteFile.method.toUpperCase(),maxConnections:this._options.maxConnections,uuidParamName:this._options.request.uuidName,customHeaders:this._deleteFileCustomHeadersStore,paramsStore:this._deleteFileParamsStore,endpointStore:this._deleteFileEndpointStore,cors:this._options.cors,log:qq.bind(e.log,e),onDelete:function(t){e._onDelete(t),e._options.callbacks.onDelete(t)},onDeleteComplete:function(t,n,i){e._onDeleteComplete(t,n,i),e._options.callbacks.onDeleteComplete(t,n,i)}})},_createPasteHandler:function(){var e=this;return new qq.PasteSupport({targetElement:this._options.paste.targetElement,callbacks:{log:qq.bind(e.log,e),pasteReceived:function(t){e._handleCheckedCallback({name:"onPasteReceived",callback:qq.bind(e._options.callbacks.onPasteReceived,e,t),onSuccess:qq.bind(e._handlePasteSuccess,e,t),identifier:"pasted image"})}}})},_createStore:function(e,t){var n={},i=e,o={},r=t,a=function(e){return qq.isObject(e)?qq.extend({},e):e},s=function(){return qq.isFunction(r)?r():r},l=function(e,t){r&&qq.isObject(t)&&qq.extend(t,s()),o[e]&&qq.extend(t,o[e])};return{set:function(e,t){null==t?(n={},i=a(e)):n[t]=a(e)},get:function(e){var t;return t=null!=e&&n[e]?n[e]:a(i),l(e,t),a(t)},addReadOnly:function(e,t){qq.isObject(n)&&(null===e?qq.isFunction(t)?r=t:(r=r||{},qq.extend(r,t)):(o[e]=o[e]||{},qq.extend(o[e],t)))},remove:function(e){return delete n[e]},reset:function(){n={},o={},i=e}}},_createUploadDataTracker:function(){var e=this;return new qq.UploadData({getName:function(t){return e.getName(t)},getUuid:function(t){return e.getUuid(t)},getSize:function(t){return e.getSize(t)},onStatusChange:function(t,n,i){e._onUploadStatusChange(t,n,i),e._options.callbacks.onStatusChange(t,n,i),e._maybeAllComplete(t,i),e._totalProgress&&setTimeout(function(){e._totalProgress.onStatusChange(t,n,i)},0)}})},_createUploadButton:function(e){function t(){return!!qq.supportedFeatures.ajaxUploading&&(!(i._options.workarounds.iosEmptyVideos&&qq.ios()&&!qq.ios6()&&i._isAllowedExtension(r,".mov"))&&(void 0===e.multiple?i._options.multiple:e.multiple))}var n,i=this,o=e.accept||this._options.validation.acceptFiles,r=e.allowedExtensions||this._options.validation.allowedExtensions;return n=new qq.UploadButton({acceptFiles:o,element:e.element,focusClass:this._options.classes.buttonFocus,folders:e.folders,hoverClass:this._options.classes.buttonHover,ios8BrowserCrashWorkaround:this._options.workarounds.ios8BrowserCrash,multiple:t(),name:this._options.request.inputName,onChange:function(e){i._onInputChange(e)},title:null==e.title?this._options.text.fileInputTitle:e.title}),this._disposeSupport.addDisposer(function(){n.dispose()}),i._buttons.push(n),n},_createUploadHandler:function(e,t){var n=this,i={},o={debug:this._options.debug,maxConnections:this._options.maxConnections,cors:this._options.cors,paramsStore:this._paramsStore,endpointStore:this._endpointStore,chunking:this._options.chunking,resume:this._options.resume,blobs:this._options.blobs,log:qq.bind(n.log,n),preventRetryParam:this._options.retry.preventRetryResponseProperty,onProgress:function(e,t,o,r){o<0||r<0||(i[e]?i[e].loaded===o&&i[e].total===r||(n._onProgress(e,t,o,r),n._options.callbacks.onProgress(e,t,o,r)):(n._onProgress(e,t,o,r),n._options.callbacks.onProgress(e,t,o,r)),i[e]={loaded:o,total:r})},onComplete:function(e,t,o,r){delete i[e];var a,s=n.getUploads({id:e}).status;s!==qq.status.UPLOAD_SUCCESSFUL&&s!==qq.status.UPLOAD_FAILED&&(a=n._onComplete(e,t,o,r),a instanceof qq.Promise?a.done(function(){n._options.callbacks.onComplete(e,t,o,r)}):n._options.callbacks.onComplete(e,t,o,r))},onCancel:function(e,t,i){var o=new qq.Promise;return n._handleCheckedCallback({name:"onCancel",callback:qq.bind(n._options.callbacks.onCancel,n,e,t),onFailure:o.failure,onSuccess:function(){i.then(function(){n._onCancel(e,t)}),o.success()},identifier:e}),o},onUploadPrep:qq.bind(this._onUploadPrep,this),onUpload:function(e,t){n._onUpload(e,t),n._options.callbacks.onUpload(e,t)},onUploadChunk:function(e,t,i){n._onUploadChunk(e,i),n._options.callbacks.onUploadChunk(e,t,i)},onUploadChunkSuccess:function(e,t,i,o){n._options.callbacks.onUploadChunkSuccess.apply(n,arguments)},onResume:function(e,t,i){return n._options.callbacks.onResume(e,t,i)},onAutoRetry:function(e,t,i,o){return n._onAutoRetry.apply(n,arguments)},onUuidChanged:function(e,t){n.log("Server requested UUID change from '"+n.getUuid(e)+"' to '"+t+"'"),n.setUuid(e,t)},getName:qq.bind(n.getName,n),getUuid:qq.bind(n.getUuid,n),getSize:qq.bind(n.getSize,n),setSize:qq.bind(n._setSize,n),getDataByUuid:function(e){return n.getUploads({uuid:e})},isQueued:function(e){var t=n.getUploads({id:e}).status;return t===qq.status.QUEUED||t===qq.status.SUBMITTED||t===qq.status.UPLOAD_RETRYING||t===qq.status.PAUSED},getIdsInProxyGroup:n._uploadData.getIdsInProxyGroup,getIdsInBatch:n._uploadData.getIdsInBatch};return qq.each(this._options.request,function(e,t){o[e]=t}),o.customHeaders=this._customHeadersStore,e&&qq.each(e,function(e,t){o[e]=t}),new qq.UploadHandlerController(o,t)},_fileOrBlobRejected:function(e){this._netUploadedOrQueued--,this._uploadData.setStatus(e,qq.status.REJECTED)},_formatSize:function(e){var t=-1;do e/=1e3,t++;while(e>999);return Math.max(e,.1).toFixed(1)+this._options.text.sizeSymbols[t]},_generateExtraButtonSpecs:function(){var e=this;this._extraButtonSpecs={},qq.each(this._options.extraButtons,function(t,n){var i=n.multiple,o=qq.extend({},e._options.validation,!0),r=qq.extend({},n);void 0===i&&(i=e._options.multiple),r.validation&&qq.extend(o,n.validation,!0),qq.extend(r,{multiple:i,validation:o},!0),e._initExtraButton(r)})},_getButton:function(e){var t=this._extraButtonSpecs[e];return t?t.element:e===this._defaultButtonId?this._options.button:void 0},_getButtonId:function(e){var t,n,i=e;if(i instanceof qq.BlobProxy&&(i=i.referenceBlob),i&&!qq.isBlob(i)){if(qq.isFile(i))return i.qqButtonId;if("input"===i.tagName.toLowerCase()&&"file"===i.type.toLowerCase())return i.getAttribute(qq.UploadButton.BUTTON_ID_ATTR_NAME);if(t=i.getElementsByTagName("input"),qq.each(t,function(e,t){if("file"===t.getAttribute("type"))return n=t,!1}),n)return n.getAttribute(qq.UploadButton.BUTTON_ID_ATTR_NAME)}},_getNotFinished:function(){return this._uploadData.retrieve({status:[qq.status.UPLOADING,qq.status.UPLOAD_RETRYING,qq.status.QUEUED,qq.status.SUBMITTING,qq.status.SUBMITTED,qq.status.PAUSED]}).length},_getValidationBase:function(e){var t=this._extraButtonSpecs[e];return t?t.validation:this._options.validation},_getValidationDescriptor:function(e){return e.file instanceof qq.BlobProxy?{name:qq.getFilename(e.file.referenceBlob),size:e.file.referenceBlob.size}:{name:this.getUploads({id:e.id}).name,size:this.getUploads({id:e.id}).size}},_getValidationDescriptors:function(e){var t=this,n=[];return qq.each(e,function(e,i){n.push(t._getValidationDescriptor(i))}),n},_handleCameraAccess:function(){if(this._options.camera.ios&&qq.ios()){var e="image/*;capture=camera",t=this._options.camera.button,n=t?this._getButtonId(t):this._defaultButtonId,i=this._options;n&&n!==this._defaultButtonId&&(i=this._extraButtonSpecs[n]),i.multiple=!1,null===i.validation.acceptFiles?i.validation.acceptFiles=e:i.validation.acceptFiles+=","+e,qq.each(this._buttons,function(e,t){if(t.getButtonId()===n)return t.setMultiple(i.multiple),t.setAcceptFiles(i.acceptFiles),!1})}},_handleCheckedCallback:function(e){var t=this,n=e.callback();return qq.isGenericPromise(n)?(this.log(e.name+" - waiting for "+e.name+" promise to be fulfilled for "+e.identifier),n.then(function(n){t.log(e.name+" promise success for "+e.identifier),e.onSuccess(n)},function(){e.onFailure?(t.log(e.name+" promise failure for "+e.identifier),e.onFailure()):t.log(e.name+" promise failure for "+e.identifier)})):(n!==!1?e.onSuccess(n):e.onFailure?(this.log(e.name+" - return value was 'false' for "+e.identifier+".  Invoking failure callback."),e.onFailure()):this.log(e.name+" - return value was 'false' for "+e.identifier+".  Will not proceed."),n)},_handleNewFile:function(e,t,n){var i=this,o=qq.getUniqueId(),r=-1,a=qq.getFilename(e),s=e.blob||e,l=this._customNewFileHandler?this._customNewFileHandler:qq.bind(i._handleNewFileGeneric,i);!qq.isInput(s)&&s.size>=0&&(r=s.size),l(s,a,o,r,n,t,this._options.request.uuidName,{uploadData:i._uploadData,paramsStore:i._paramsStore,addFileToHandler:function(e,t){i._handler.add(e,t),i._netUploadedOrQueued++,i._trackButton(e)}})},_handleNewFileGeneric:function(e,t,n,i,o,r){var a=this._uploadData.addFile({uuid:n,name:t,size:i,batchId:r});this._handler.add(a,e),this._trackButton(a),this._netUploadedOrQueued++,o.push({id:a,file:e})},
_handlePasteSuccess:function(e,t){var n=e.type.split("/")[1],i=t;null==i&&(i=this._options.paste.defaultName),i+="."+n,this.addFiles({name:i,blob:e})},_initExtraButton:function(e){var t=this._createUploadButton({accept:e.validation.acceptFiles,allowedExtensions:e.validation.allowedExtensions,element:e.element,folders:e.folders,multiple:e.multiple,title:e.fileInputTitle});this._extraButtonSpecs[t.getButtonId()]=e},_initFormSupportAndParams:function(){this._formSupport=qq.FormSupport&&new qq.FormSupport(this._options.form,qq.bind(this.uploadStoredFiles,this),qq.bind(this.log,this)),this._formSupport&&this._formSupport.attachedToForm?(this._paramsStore=this._createStore(this._options.request.params,this._formSupport.getFormInputsAsObject),this._options.autoUpload=this._formSupport.newAutoUpload,this._formSupport.newEndpoint&&(this._options.request.endpoint=this._formSupport.newEndpoint)):this._paramsStore=this._createStore(this._options.request.params)},_isDeletePossible:function(){return!(!qq.DeleteFileAjaxRequester||!this._options.deleteFile.enabled)&&(!this._options.cors.expected||(!!qq.supportedFeatures.deleteFileCorsXhr||!(!qq.supportedFeatures.deleteFileCorsXdr||!this._options.cors.allowXdr)))},_isAllowedExtension:function(e,t){var n=!1;return!e.length||(qq.each(e,function(e,i){if(qq.isString(i)){var o=new RegExp("\\."+i+"$","i");if(null!=t.match(o))return n=!0,!1}}),n)},_itemError:function(e,t,n){function i(e,t){a=a.replace(e,t)}var o,r,a=this._options.messages[e],s=[],l=[].concat(t),u=l[0],c=this._getButtonId(n),d=this._getValidationBase(c);return qq.each(d.allowedExtensions,function(e,t){qq.isString(t)&&s.push(t)}),o=s.join(", ").toLowerCase(),i("{file}",this._options.formatFileName(u)),i("{extensions}",o),i("{sizeLimit}",this._formatSize(d.sizeLimit)),i("{minSizeLimit}",this._formatSize(d.minSizeLimit)),r=a.match(/(\{\w+\})/g),null!==r&&qq.each(r,function(e,t){i(t,l[e])}),this._options.callbacks.onError(null,u,a,void 0),a},_manualRetry:function(e,t){if(this._onBeforeManualRetry(e))return this._netUploadedOrQueued++,this._uploadData.setStatus(e,qq.status.UPLOAD_RETRYING),t?t(e):this._handler.retry(e),!0},_maybeAllComplete:function(e,t){var n=this,i=this._getNotFinished();t===qq.status.UPLOAD_SUCCESSFUL?this._succeededSinceLastAllComplete.push(e):t===qq.status.UPLOAD_FAILED&&this._failedSinceLastAllComplete.push(e),0===i&&(this._succeededSinceLastAllComplete.length||this._failedSinceLastAllComplete.length)&&setTimeout(function(){n._onAllComplete(n._succeededSinceLastAllComplete,n._failedSinceLastAllComplete)},0)},_maybeHandleIos8SafariWorkaround:function(){var e=this;if(this._options.workarounds.ios8SafariUploads&&qq.ios800()&&qq.iosSafari())throw setTimeout(function(){window.alert(e._options.messages.unsupportedBrowserIos8Safari)},0),new qq.Error(this._options.messages.unsupportedBrowserIos8Safari)},_maybeParseAndSendUploadError:function(e,t,n,i){if(!n.success)if(i&&200!==i.status&&!n.error)this._options.callbacks.onError(e,t,"XHR returned response code "+i.status,i);else{var o=n.error?n.error:this._options.text.defaultResponseError;this._options.callbacks.onError(e,t,o,i)}},_maybeProcessNextItemAfterOnValidateCallback:function(e,t,n,i,o){var r=this;if(t.length>n)if(e||!this._options.validation.stopOnFirstInvalidFile)setTimeout(function(){var e=r._getValidationDescriptor(t[n]),a=r._getButtonId(t[n].file),s=r._getButton(a);r._handleCheckedCallback({name:"onValidate",callback:qq.bind(r._options.callbacks.onValidate,r,e,s),onSuccess:qq.bind(r._onValidateCallbackSuccess,r,t,n,i,o),onFailure:qq.bind(r._onValidateCallbackFailure,r,t,n,i,o),identifier:"Item '"+e.name+"', size: "+e.size})},0);else if(!e)for(;n<t.length;n++)r._fileOrBlobRejected(t[n].id)},_onAllComplete:function(e,t){this._totalProgress&&this._totalProgress.onAllComplete(e,t,this._preventRetries),this._options.callbacks.onAllComplete(qq.extend([],e),qq.extend([],t)),this._succeededSinceLastAllComplete=[],this._failedSinceLastAllComplete=[]},_onAutoRetry:function(e,t,n,i,o){var r=this;if(r._preventRetries[e]=n[r._options.retry.preventRetryResponseProperty],r._shouldAutoRetry(e,t,n))return r._maybeParseAndSendUploadError.apply(r,arguments),r._options.callbacks.onAutoRetry(e,t,r._autoRetries[e]),r._onBeforeAutoRetry(e,t),r._retryTimeouts[e]=setTimeout(function(){r.log("Retrying "+t+"..."),r._uploadData.setStatus(e,qq.status.UPLOAD_RETRYING),o?o(e):r._handler.retry(e)},1e3*r._options.retry.autoAttemptDelay),!0},_onBeforeAutoRetry:function(e,t){this.log("Waiting "+this._options.retry.autoAttemptDelay+" seconds before retrying "+t+"...")},_onBeforeManualRetry:function(e){var t,n=this._currentItemLimit;return this._preventRetries[e]?(this.log("Retries are forbidden for id "+e,"warn"),!1):this._handler.isValid(e)?(t=this.getName(e),this._options.callbacks.onManualRetry(e,t)!==!1&&(n>0&&this._netUploadedOrQueued+1>n?(this._itemError("retryFailTooManyItems"),!1):(this.log("Retrying upload for '"+t+"' (id: "+e+")..."),!0))):(this.log("'"+e+"' is not a valid file ID","error"),!1)},_onCancel:function(e,t){this._netUploadedOrQueued--,clearTimeout(this._retryTimeouts[e]);var n=qq.indexOf(this._storedIds,e);!this._options.autoUpload&&n>=0&&this._storedIds.splice(n,1),this._uploadData.setStatus(e,qq.status.CANCELED)},_onComplete:function(e,t,n,i){return n.success?(n.thumbnailUrl&&(this._thumbnailUrls[e]=n.thumbnailUrl),this._netUploaded++,this._uploadData.setStatus(e,qq.status.UPLOAD_SUCCESSFUL)):(this._netUploadedOrQueued--,this._uploadData.setStatus(e,qq.status.UPLOAD_FAILED),n[this._options.retry.preventRetryResponseProperty]===!0&&(this._preventRetries[e]=!0)),this._maybeParseAndSendUploadError(e,t,n,i),!!n.success},_onDelete:function(e){this._uploadData.setStatus(e,qq.status.DELETING)},_onDeleteComplete:function(e,t,n){var i=this.getName(e);n?(this._uploadData.setStatus(e,qq.status.DELETE_FAILED),this.log("Delete request for '"+i+"' has failed.","error"),void 0===t.withCredentials?this._options.callbacks.onError(e,i,"Delete request failed",t):this._options.callbacks.onError(e,i,"Delete request failed with response code "+t.status,t)):(this._netUploadedOrQueued--,this._netUploaded--,this._handler.expunge(e),this._uploadData.setStatus(e,qq.status.DELETED),this.log("Delete request for '"+i+"' has succeeded."))},_onInputChange:function(e){var t;if(qq.supportedFeatures.ajaxUploading){for(t=0;t<e.files.length;t++)this._annotateWithButtonId(e.files[t],e);this.addFiles(e.files)}else e.value.length>0&&this.addFiles(e);qq.each(this._buttons,function(e,t){t.reset()})},_onProgress:function(e,t,n,i){this._totalProgress&&this._totalProgress.onIndividualProgress(e,n,i)},_onSubmit:function(e,t){},_onSubmitCallbackSuccess:function(e,t){this._onSubmit.apply(this,arguments),this._uploadData.setStatus(e,qq.status.SUBMITTED),this._onSubmitted.apply(this,arguments),this._options.autoUpload?(this._options.callbacks.onSubmitted.apply(this,arguments),this._uploadFile(e)):(this._storeForLater(e),this._options.callbacks.onSubmitted.apply(this,arguments))},_onSubmitDelete:function(e,t,n){var i,o=this.getUuid(e);return t&&(i=qq.bind(t,this,e,o,n)),this._isDeletePossible()?(this._handleCheckedCallback({name:"onSubmitDelete",callback:qq.bind(this._options.callbacks.onSubmitDelete,this,e),onSuccess:i||qq.bind(this._deleteHandler.sendDelete,this,e,o,n),identifier:e}),!0):(this.log("Delete request ignored for ID "+e+", delete feature is disabled or request not possible due to CORS on a user agent that does not support pre-flighting.","warn"),!1)},_onSubmitted:function(e){},_onTotalProgress:function(e,t){this._options.callbacks.onTotalProgress(e,t)},_onUploadPrep:function(e){},_onUpload:function(e,t){this._uploadData.setStatus(e,qq.status.UPLOADING)},_onUploadChunk:function(e,t){},_onUploadStatusChange:function(e,t,n){n===qq.status.PAUSED&&clearTimeout(this._retryTimeouts[e])},_onValidateBatchCallbackFailure:function(e){var t=this;qq.each(e,function(e,n){t._fileOrBlobRejected(n.id)})},_onValidateBatchCallbackSuccess:function(e,t,n,i,o){var r,a=this._currentItemLimit,s=this._netUploadedOrQueued;0===a||s<=a?t.length>0?this._handleCheckedCallback({name:"onValidate",callback:qq.bind(this._options.callbacks.onValidate,this,e[0],o),onSuccess:qq.bind(this._onValidateCallbackSuccess,this,t,0,n,i),onFailure:qq.bind(this._onValidateCallbackFailure,this,t,0,n,i),identifier:"Item '"+t[0].file.name+"', size: "+t[0].file.size}):this._itemError("noFilesError"):(this._onValidateBatchCallbackFailure(t),r=this._options.messages.tooManyItemsError.replace(/\{netItems\}/g,s).replace(/\{itemLimit\}/g,a),this._batchError(r))},_onValidateCallbackFailure:function(e,t,n,i){var o=t+1;this._fileOrBlobRejected(e[t].id,e[t].file.name),this._maybeProcessNextItemAfterOnValidateCallback(!1,e,o,n,i)},_onValidateCallbackSuccess:function(e,t,n,i){var o=this,r=t+1,a=this._getValidationDescriptor(e[t]);this._validateFileOrBlobData(e[t],a).then(function(){o._upload(e[t].id,n,i),o._maybeProcessNextItemAfterOnValidateCallback(!0,e,r,n,i)},function(){o._maybeProcessNextItemAfterOnValidateCallback(!1,e,r,n,i)})},_prepareItemsForUpload:function(e,t,n){if(0===e.length)return void this._itemError("noFilesError");var i=this._getValidationDescriptors(e),o=this._getButtonId(e[0].file),r=this._getButton(o);this._handleCheckedCallback({name:"onValidateBatch",callback:qq.bind(this._options.callbacks.onValidateBatch,this,i,r),onSuccess:qq.bind(this._onValidateBatchCallbackSuccess,this,i,e,t,n,r),onFailure:qq.bind(this._onValidateBatchCallbackFailure,this,e),identifier:"batch validation"})},_preventLeaveInProgress:function(){var e=this;this._disposeSupport.attach(window,"beforeunload",function(t){if(e.getInProgress())return t=t||window.event,t.returnValue=e._options.messages.onLeave,e._options.messages.onLeave})},_refreshSessionData:function(){var e=this,t=this._options.session;qq.Session&&null!=this._options.session.endpoint&&(this._session||(qq.extend(t,this._options.cors),t.log=qq.bind(this.log,this),t.addFileRecord=qq.bind(this._addCannedFile,this),this._session=new qq.Session(t)),setTimeout(function(){e._session.refresh().then(function(t,n){e._sessionRequestComplete(),e._options.callbacks.onSessionRequestComplete(t,!0,n)},function(t,n){e._options.callbacks.onSessionRequestComplete(t,!1,n)})},0))},_sessionRequestComplete:function(){},_setSize:function(e,t){this._uploadData.updateSize(e,t),this._totalProgress&&this._totalProgress.onNewSize(e)},_shouldAutoRetry:function(e,t,n){var i=this._uploadData.retrieve({id:e});return!!(!this._preventRetries[e]&&this._options.retry.enableAuto&&i.status!==qq.status.PAUSED&&(void 0===this._autoRetries[e]&&(this._autoRetries[e]=0),this._autoRetries[e]<this._options.retry.maxAutoAttempts))&&(this._autoRetries[e]+=1,!0)},_storeForLater:function(e){this._storedIds.push(e)},_trackButton:function(e){var t;t=qq.supportedFeatures.ajaxUploading?this._handler.getFile(e).qqButtonId:this._getButtonId(this._handler.getInput(e)),t&&(this._buttonIdsForFileIds[e]=t)},_updateFormSupportAndParams:function(e){this._options.form.element=e,this._formSupport=qq.FormSupport&&new qq.FormSupport(this._options.form,qq.bind(this.uploadStoredFiles,this),qq.bind(this.log,this)),this._formSupport&&this._formSupport.attachedToForm&&(this._paramsStore.addReadOnly(null,this._formSupport.getFormInputsAsObject),this._options.autoUpload=this._formSupport.newAutoUpload,this._formSupport.newEndpoint&&this.setEndpoint(this._formSupport.newEndpoint))},_upload:function(e,t,n){var i=this.getName(e);t&&this.setParams(t,e),n&&this.setEndpoint(n,e),this._handleCheckedCallback({name:"onSubmit",callback:qq.bind(this._options.callbacks.onSubmit,this,e,i),onSuccess:qq.bind(this._onSubmitCallbackSuccess,this,e,i),onFailure:qq.bind(this._fileOrBlobRejected,this,e,i),identifier:e})},_uploadFile:function(e){this._handler.upload(e)||this._uploadData.setStatus(e,qq.status.QUEUED)},_uploadStoredFiles:function(){for(var e,t,n=this;this._storedIds.length;)e=this._storedIds.shift(),this._uploadFile(e);t=this.getUploads({status:qq.status.SUBMITTING}).length,t&&(qq.log("Still waiting for "+t+" files to clear submit queue. Will re-parse stored IDs array shortly."),setTimeout(function(){n._uploadStoredFiles()},1e3))},_validateFileOrBlobData:function(e,t){var n=this,i=function(){return e.file instanceof qq.BlobProxy?e.file.referenceBlob:e.file}(),o=t.name,r=t.size,a=this._getButtonId(e.file),s=this._getValidationBase(a),l=new qq.Promise;return l.then(function(){},function(){n._fileOrBlobRejected(e.id,o)}),qq.isFileOrInput(i)&&!this._isAllowedExtension(s.allowedExtensions,o)?(this._itemError("typeError",o,i),l.failure()):0===r?(this._itemError("emptyError",o,i),l.failure()):r>0&&s.sizeLimit&&r>s.sizeLimit?(this._itemError("sizeError",o,i),l.failure()):r>0&&r<s.minSizeLimit?(this._itemError("minSizeError",o,i),l.failure()):(qq.ImageValidation&&qq.supportedFeatures.imagePreviews&&qq.isFile(i)?new qq.ImageValidation(i,qq.bind(n.log,n)).validate(s.image).then(l.success,function(e){n._itemError(e+"ImageError",o,i),l.failure()}):l.success(),l)},_wrapCallbacks:function(){var e,t,n;e=this,t=function(t,n,i){var o;try{return n.apply(e,i)}catch(r){o=r.message||r.toString(),e.log("Caught exception in '"+t+"' callback - "+o,"error")}};for(n in this._options.callbacks)!function(){var i,o;i=n,o=e._options.callbacks[i],e._options.callbacks[i]=function(){return t(i,o,arguments)}}()}}}(),function(){"use strict";qq.FineUploaderBasic=function(e){var t=this;this._options={debug:!1,button:null,multiple:!0,maxConnections:3,disableCancelForFormUploads:!1,autoUpload:!0,request:{customHeaders:{},endpoint:"/server/upload",filenameParam:"qqfilename",forceMultipart:!0,inputName:"qqfile",method:"POST",params:{},paramsInBody:!0,totalFileSizeName:"qqtotalfilesize",uuidName:"qquuid"},validation:{allowedExtensions:[],sizeLimit:0,minSizeLimit:0,itemLimit:0,stopOnFirstInvalidFile:!0,acceptFiles:null,image:{maxHeight:0,maxWidth:0,minHeight:0,minWidth:0}},callbacks:{onSubmit:function(e,t){},onSubmitted:function(e,t){},onComplete:function(e,t,n,i){},onAllComplete:function(e,t){},onCancel:function(e,t){},onUpload:function(e,t){},onUploadChunk:function(e,t,n){},onUploadChunkSuccess:function(e,t,n,i){},onResume:function(e,t,n){},onProgress:function(e,t,n,i){},onTotalProgress:function(e,t){},onError:function(e,t,n,i){},onAutoRetry:function(e,t,n){},onManualRetry:function(e,t){},onValidateBatch:function(e){},onValidate:function(e){},onSubmitDelete:function(e){},onDelete:function(e){},onDeleteComplete:function(e,t,n){},onPasteReceived:function(e){},onStatusChange:function(e,t,n){},onSessionRequestComplete:function(e,t,n){}},messages:{typeError:"{file} has an invalid extension. Valid extension(s): {extensions}.",sizeError:"{file} is too large, maximum file size is {sizeLimit}.",minSizeError:"{file} is too small, minimum file size is {minSizeLimit}.",emptyError:"{file} is empty, please select files again without it.",noFilesError:"No files to upload.",tooManyItemsError:"Too many items ({netItems}) would be uploaded.  Item limit is {itemLimit}.",maxHeightImageError:"Image is too tall.",maxWidthImageError:"Image is too wide.",minHeightImageError:"Image is not tall enough.",minWidthImageError:"Image is not wide enough.",retryFailTooManyItems:"Retry failed - you have reached your file limit.",onLeave:"The files are being uploaded, if you leave now the upload will be canceled.",unsupportedBrowserIos8Safari:"Unrecoverable error - this browser does not permit file uploading of any kind due to serious bugs in iOS8 Safari.  Please use iOS8 Chrome until Apple fixes these issues."},retry:{enableAuto:!1,maxAutoAttempts:3,autoAttemptDelay:5,preventRetryResponseProperty:"preventRetry"},classes:{buttonHover:"qq-upload-button-hover",buttonFocus:"qq-upload-button-focus"},chunking:{enabled:!1,concurrent:{enabled:!1},mandatory:!1,paramNames:{partIndex:"qqpartindex",partByteOffset:"qqpartbyteoffset",chunkSize:"qqchunksize",totalFileSize:"qqtotalfilesize",totalParts:"qqtotalparts"},partSize:2e6,success:{endpoint:null}},resume:{enabled:!1,recordsExpireIn:7,paramNames:{resuming:"qqresume"}},formatFileName:function(e){return e},text:{defaultResponseError:"Upload failure reason unknown",fileInputTitle:"file input",sizeSymbols:["kB","MB","GB","TB","PB","EB"]},deleteFile:{enabled:!1,method:"DELETE",endpoint:"/server/upload",customHeaders:{},params:{}},cors:{expected:!1,sendCredentials:!1,allowXdr:!1},blobs:{defaultName:"misc_data"},paste:{targetElement:null,defaultName:"pasted_image"},camera:{ios:!1,button:null},extraButtons:[],session:{endpoint:null,params:{},customHeaders:{},refreshOnReset:!0},form:{element:"qq-form",autoUpload:!1,interceptSubmit:!0},scaling:{customResizer:null,sendOriginal:!0,orient:!0,defaultType:null,defaultQuality:80,failureText:"Failed to scale",includeExif:!1,sizes:[]},workarounds:{iosEmptyVideos:!0,ios8SafariUploads:!0,ios8BrowserCrash:!1}},qq.extend(this._options,e,!0),this._buttons=[],this._extraButtonSpecs={},this._buttonIdsForFileIds=[],this._wrapCallbacks(),this._disposeSupport=new qq.DisposeSupport,this._storedIds=[],this._autoRetries=[],this._retryTimeouts=[],this._preventRetries=[],this._thumbnailUrls=[],this._netUploadedOrQueued=0,this._netUploaded=0,this._uploadData=this._createUploadDataTracker(),this._initFormSupportAndParams(),this._customHeadersStore=this._createStore(this._options.request.customHeaders),this._deleteFileCustomHeadersStore=this._createStore(this._options.deleteFile.customHeaders),this._deleteFileParamsStore=this._createStore(this._options.deleteFile.params),this._endpointStore=this._createStore(this._options.request.endpoint),this._deleteFileEndpointStore=this._createStore(this._options.deleteFile.endpoint),this._handler=this._createUploadHandler(),this._deleteHandler=qq.DeleteFileAjaxRequester&&this._createDeleteHandler(),this._options.button&&(this._defaultButtonId=this._createUploadButton({element:this._options.button,title:this._options.text.fileInputTitle}).getButtonId()),this._generateExtraButtonSpecs(),this._handleCameraAccess(),this._options.paste.targetElement&&(qq.PasteSupport?this._pasteHandler=this._createPasteHandler():this.log("Paste support module not found","error")),this._preventLeaveInProgress(),this._imageGenerator=qq.ImageGenerator&&new qq.ImageGenerator(qq.bind(this.log,this)),this._refreshSessionData(),this._succeededSinceLastAllComplete=[],this._failedSinceLastAllComplete=[],this._scaler=qq.Scaler&&new qq.Scaler(this._options.scaling,qq.bind(this.log,this))||{},this._scaler.enabled&&(this._customNewFileHandler=qq.bind(this._scaler.handleNewFile,this._scaler)),qq.TotalProgress&&qq.supportedFeatures.progressBar&&(this._totalProgress=new qq.TotalProgress(qq.bind(this._onTotalProgress,this),function(e){var n=t._uploadData.retrieve({id:e});return n&&n.size||0})),this._currentItemLimit=this._options.validation.itemLimit},qq.FineUploaderBasic.prototype=qq.basePublicApi,qq.extend(qq.FineUploaderBasic.prototype,qq.basePrivateApi)}(),qq.AjaxRequester=function(e){"use strict";function t(){return qq.indexOf(["GET","POST","HEAD"],S.method)>=0}function n(e){var t=!1;return qq.each(t,function(e,n){if(qq.indexOf(["Accept","Accept-Language","Content-Language","Content-Type"],n)<0)return t=!0,!1}),t}function i(e){return S.cors.expected&&void 0===e.withCredentials}function o(){var e;return(window.XMLHttpRequest||window.ActiveXObject)&&(e=qq.createXhrInstance(),void 0===e.withCredentials&&(e=new XDomainRequest,e.onload=function(){},e.onerror=function(){},e.ontimeout=function(){},e.onprogress=function(){})),e}function r(e,t){var n=y[e].xhr;return n||(n=t?t:S.cors.expected?o():qq.createXhrInstance(),y[e].xhr=n),n}function a(e){var t,n=qq.indexOf(b,e),i=S.maxConnections;delete y[e],b.splice(n,1),b.length>=i&&n<i&&(t=b[i-1],u(t))}function s(e,t){var n=r(e),o=S.method,s=t===!0;a(e),s?_(o+" request for "+e+" has failed","error"):i(n)||m(n.status)||(s=!0,_(o+" request for "+e+" has failed - response code "+n.status,"error")),S.onComplete(e,n,s)}function l(e){var t,n=y[e].additionalParams,i=S.mandatedParams;return S.paramsStore.get&&(t=S.paramsStore.get(e)),n&&qq.each(n,function(e,n){t=t||{},t[e]=n}),i&&qq.each(i,function(e,n){t=t||{},t[e]=n}),t}function u(e,t){var n,o=r(e,t),a=S.method,s=l(e),u=y[e].payload;return S.onSend(e),n=c(e,s,y[e].additionalQueryParams),i(o)?(o.onload=h(e),o.onerror=q(e)):o.onreadystatechange=d(e),p(e),o.open(a,n,!0),S.cors.expected&&S.cors.sendCredentials&&!i(o)&&(o.withCredentials=!0),f(e),_("Sending "+a+" request for "+e),u?o.send(u):v||!s?o.send():s&&S.contentType&&S.contentType.toLowerCase().indexOf("application/x-www-form-urlencoded")>=0?o.send(qq.obj2url(s,"")):s&&S.contentType&&S.contentType.toLowerCase().indexOf("application/json")>=0?o.send(JSON.stringify(s)):o.send(s),o}function c(e,t,n){var i=S.endpointStore.get(e),o=y[e].addToPath;return void 0!=o&&(i+="/"+o),v&&t&&(i=qq.obj2url(t,i)),n&&(i=qq.obj2url(n,i)),i}function d(e){return function(){4===r(e).readyState&&s(e)}}function p(e){var t=S.onProgress;t&&(r(e).upload.onprogress=function(n){n.lengthComputable&&t(e,n.loaded,n.total)})}function h(e){return function(){s(e)}}function q(e){return function(){s(e,!0)}}function f(e){var o=r(e),a=S.customHeaders,s=y[e].additionalHeaders||{},l=S.method,u={};i(o)||(S.acceptHeader&&o.setRequestHeader("Accept",S.acceptHeader),S.allowXRequestedWithAndCacheControl&&(S.cors.expected&&t()&&!n(a)||(o.setRequestHeader("X-Requested-With","XMLHttpRequest"),o.setRequestHeader("Cache-Control","no-cache"))),!S.contentType||"POST"!==l&&"PUT"!==l||o.setRequestHeader("Content-Type",S.contentType),qq.extend(u,qq.isFunction(a)?a(e):a),qq.extend(u,s),qq.each(u,function(e,t){o.setRequestHeader(e,t)}))}function m(e){return qq.indexOf(S.successfulResponseCodes[S.method],e)>=0}function g(e,t,n,i,o,r,a){y[e]={addToPath:n,additionalParams:i,additionalQueryParams:o,additionalHeaders:r,payload:a};var s=b.push(e);if(s<=S.maxConnections)return u(e,t)}var _,v,b=[],y={},S={acceptHeader:null,validMethods:["PATCH","POST","PUT"],method:"POST",contentType:"application/x-www-form-urlencoded",maxConnections:3,customHeaders:{},endpointStore:{},paramsStore:{},mandatedParams:{},allowXRequestedWithAndCacheControl:!0,successfulResponseCodes:{DELETE:[200,202,204],PATCH:[200,201,202,203,204],POST:[200,201,202,203,204],PUT:[200,201,202,203,204],GET:[200]},cors:{expected:!1,sendCredentials:!1},log:function(e,t){},onSend:function(e){},onComplete:function(e,t,n){},onProgress:null};if(qq.extend(S,e),_=S.log,qq.indexOf(S.validMethods,S.method)<0)throw new Error("'"+S.method+"' is not a supported method for this type of request!");v="GET"===S.method||"DELETE"===S.method,qq.extend(this,{initTransport:function(e){var t,n,i,o,r,a;return{withPath:function(e){return t=e,this},withParams:function(e){return n=e,this},withQueryParams:function(e){return a=e,this},withHeaders:function(e){return i=e,this},withPayload:function(e){return o=e,this},withCacheBuster:function(){return r=!0,this},send:function(s){return r&&qq.indexOf(["GET","DELETE"],S.method)>=0&&(n.qqtimestamp=(new Date).getTime()),g(e,s,t,n,a,i,o)}}},canceled:function(e){a(e)}})},qq.UploadHandler=function(e){"use strict";var t=e.proxy,n={},i=t.onCancel,o=t.getName;qq.extend(this,{add:function(e,t){n[e]=t,n[e].temp={}},cancel:function(e){var t=this,r=new qq.Promise,a=i(e,o(e),r);a.then(function(){t.isValid(e)&&(n[e].canceled=!0,t.expunge(e)),r.success()})},expunge:function(e){delete n[e]},getThirdPartyFileId:function(e){return n[e].key},isValid:function(e){return void 0!==n[e]},reset:function(){n={}},_getFileState:function(e){return n[e]},_setThirdPartyFileId:function(e,t){n[e].key=t},_wasCanceled:function(e){return!!n[e].canceled}})},qq.UploadHandlerController=function(e,t){"use strict";var n,i,o,r=this,a=!1,s=!1,l={paramsStore:{},maxConnections:3,chunking:{enabled:!1,multiple:{enabled:!1}},log:function(e,t){},onProgress:function(e,t,n,i){},onComplete:function(e,t,n,i){},onCancel:function(e,t){},onUploadPrep:function(e){},onUpload:function(e,t){},onUploadChunk:function(e,t,n){},onUploadChunkSuccess:function(e,t,n,i){},onAutoRetry:function(e,t,n,i){},onResume:function(e,t,n){},onUuidChanged:function(e,t){},getName:function(e){},setSize:function(e,t){},isQueued:function(e){},getIdsInProxyGroup:function(e){},getIdsInBatch:function(e){}},u={done:function(e,t,n,i){var r=o._getChunkData(e,t);o._getFileState(e).attemptingResume=!1,delete o._getFileState(e).temp.chunkProgress[t],o._getFileState(e).loaded+=r.size,l.onUploadChunkSuccess(e,o._getChunkDataForCallback(r),n,i)},finalize:function(e){var t=l.getSize(e),n=l.getName(e);i("All chunks have been uploaded for "+e+" - finalizing...."),o.finalizeChunks(e).then(function(r,a){i("Finalize successful for "+e);var s=p.normalizeResponse(r,!0);l.onProgress(e,n,t,t),o._maybeDeletePersistedChunkData(e),p.cleanup(e,s,a)},function(t,o){var r=p.normalizeResponse(t,!1);i("Problem finalizing chunks for file ID "+e+" - "+r.error,"error"),r.reset&&u.reset(e),l.onAutoRetry(e,n,r,o)||p.cleanup(e,r,o)})},hasMoreParts:function(e){return!!o._getFileState(e).chunking.remaining.length},nextPart:function(e){var t=o._getFileState(e).chunking.remaining.shift();return t>=o._getTotalChunks(e)&&(t=null),t},reset:function(e){i("Server or callback has ordered chunking effort to be restarted on next attempt for item ID "+e,"error"),o._maybeDeletePersistedChunkData(e),o.reevaluateChunking(e),o._getFileState(e).loaded=0},sendNext:function(e){var t=l.getSize(e),n=l.getName(e),r=u.nextPart(e),a=o._getChunkData(e,r),d=o._getFileState(e).attemptingResume,h=o._getFileState(e).chunking.inProgress||[];null==o._getFileState(e).loaded&&(o._getFileState(e).loaded=0),d&&l.onResume(e,n,a)===!1&&(u.reset(e),r=u.nextPart(e),a=o._getChunkData(e,r),d=!1),null==r&&0===h.length?u.finalize(e):(i(qq.format("Sending chunked upload request for item {}.{}, bytes {}-{} of {}.",e,r,a.start+1,a.end,t)),l.onUploadChunk(e,n,o._getChunkDataForCallback(a)),h.push(r),o._getFileState(e).chunking.inProgress=h,s&&c.open(e,r),s&&c.available()&&o._getFileState(e).chunking.remaining.length&&u.sendNext(e),o.uploadChunk(e,r,d).then(function(t,n){i("Chunked upload request succeeded for "+e+", chunk "+r),o.clearCachedChunk(e,r);var a=o._getFileState(e).chunking.inProgress||[],s=p.normalizeResponse(t,!0),l=qq.indexOf(a,r);i(qq.format("Chunk {} for file {} uploaded successfully.",r,e)),u.done(e,r,s,n),l>=0&&a.splice(l,1),o._maybePersistChunkedState(e),u.hasMoreParts(e)||0!==a.length?u.hasMoreParts(e)?u.sendNext(e):i(qq.format("File ID {} has no more chunks to send and these chunk indexes are still marked as in-progress: {}",e,JSON.stringify(a))):u.finalize(e)},function(t,a){i("Chunked upload request failed for "+e+", chunk "+r),o.clearCachedChunk(e,r);var d,h=p.normalizeResponse(t,!1);h.reset?u.reset(e):(d=qq.indexOf(o._getFileState(e).chunking.inProgress,r),d>=0&&(o._getFileState(e).chunking.inProgress.splice(d,1),o._getFileState(e).chunking.remaining.unshift(r))),o._getFileState(e).temp.ignoreFailure||(s&&(o._getFileState(e).temp.ignoreFailure=!0,i(qq.format("Going to attempt to abort these chunks: {}. These are currently in-progress: {}.",JSON.stringify(Object.keys(o._getXhrs(e))),JSON.stringify(o._getFileState(e).chunking.inProgress))),qq.each(o._getXhrs(e),function(t,n){i(qq.format("Attempting to abort file {}.{}. XHR readyState {}. ",e,t,n.readyState)),n.abort(),n._cancelled=!0}),o.moveInProgressToRemaining(e),c.free(e,!0)),l.onAutoRetry(e,n,h,a)||p.cleanup(e,h,a))}).done(function(){o.clearXhr(e,r)}))}},c={_open:[],_openChunks:{},_waiting:[],available:function(){var e=l.maxConnections,t=0,n=0;return qq.each(c._openChunks,function(e,i){t++,n+=i.length}),e-(c._open.length-t+n)},free:function(e,t){var n,r=!t,a=qq.indexOf(c._waiting,e),s=qq.indexOf(c._open,e);delete c._openChunks[e],p.getProxyOrBlob(e)instanceof qq.BlobProxy&&(i("Generated blob upload has ended for "+e+", disposing generated blob."),delete o._getFileState(e).file),a>=0?c._waiting.splice(a,1):r&&s>=0&&(c._open.splice(s,1),n=c._waiting.shift(),n>=0&&(c._open.push(n),p.start(n)))},getWaitingOrConnected:function(){var e=[];return qq.each(c._openChunks,function(t,n){n&&n.length&&e.push(parseInt(t))}),qq.each(c._open,function(t,n){c._openChunks[n]||e.push(parseInt(n))}),e=e.concat(c._waiting)},isUsingConnection:function(e){return qq.indexOf(c._open,e)>=0},open:function(e,t){return null==t&&c._waiting.push(e),!!c.available()&&(null==t?(c._waiting.pop(),c._open.push(e)):!function(){var n=c._openChunks[e]||[];n.push(t),c._openChunks[e]=n}(),!0)},reset:function(){c._waiting=[],c._open=[]}},d={send:function(e,t){o._getFileState(e).loaded=0,i("Sending simple upload request for "+e),o.uploadFile(e).then(function(n,o){i("Simple upload request succeeded for "+e);var r=p.normalizeResponse(n,!0),a=l.getSize(e);l.onProgress(e,t,a,a),p.maybeNewUuid(e,r),p.cleanup(e,r,o)},function(n,o){i("Simple upload request failed for "+e);var r=p.normalizeResponse(n,!1);l.onAutoRetry(e,t,r,o)||p.cleanup(e,r,o)})}},p={cancel:function(e){i("Cancelling "+e),l.paramsStore.remove(e),c.free(e)},cleanup:function(e,t,n){var i=l.getName(e);l.onComplete(e,i,t,n),o._getFileState(e)&&o._clearXhrs&&o._clearXhrs(e),c.free(e)},getProxyOrBlob:function(e){return o.getProxy&&o.getProxy(e)||o.getFile&&o.getFile(e)},initHandler:function(){var e=t?qq[t]:qq.traditional,n=qq.supportedFeatures.ajaxUploading?"Xhr":"Form";o=new e[n+"UploadHandler"](l,{getDataByUuid:l.getDataByUuid,getName:l.getName,getSize:l.getSize,getUuid:l.getUuid,log:i,onCancel:l.onCancel,onProgress:l.onProgress,onUuidChanged:l.onUuidChanged}),o._removeExpiredChunkingRecords&&o._removeExpiredChunkingRecords()},isDeferredEligibleForUpload:function(e){return l.isQueued(e)},maybeDefer:function(e,t){return t&&!o.getFile(e)&&t instanceof qq.BlobProxy?(l.onUploadPrep(e),i("Attempting to generate a blob on-demand for "+e),t.create().then(function(t){i("Generated an on-demand blob for "+e),o.updateBlob(e,t),l.setSize(e,t.size),o.reevaluateChunking(e),p.maybeSendDeferredFiles(e)},function(t){var o={};t&&(o.error=t),i(qq.format("Failed to generate blob for ID {}.  Error message: {}.",e,t),"error"),l.onComplete(e,l.getName(e),qq.extend(o,n),null),p.maybeSendDeferredFiles(e),c.free(e)}),!1):p.maybeSendDeferredFiles(e)},maybeSendDeferredFiles:function(e){var t=l.getIdsInProxyGroup(e),n=!1;return t&&t.length?(i("Maybe ready to upload proxy group file "+e),qq.each(t,function(t,i){if(p.isDeferredEligibleForUpload(i)&&o.getFile(i))n=i===e,p.now(i);else if(p.isDeferredEligibleForUpload(i))return!1})):(n=!0,p.now(e)),n},maybeNewUuid:function(e,t){void 0!==t.newUuid&&l.onUuidChanged(e,t.newUuid)},normalizeResponse:function(e,t){var n=e;return qq.isObject(e)||(n={},qq.isString(e)&&!t&&(n.error=e)),n.success=t,n},now:function(e){var t=l.getName(e);if(!r.isValid(e))throw new qq.Error(e+" is not a valid file ID to upload!");l.onUpload(e,t),a&&o._shouldChunkThisFile(e)?u.sendNext(e):d.send(e,t)},start:function(e){var t=p.getProxyOrBlob(e);return t?p.maybeDefer(e,t):(p.now(e),!0)}};qq.extend(this,{add:function(e,t){o.add.apply(this,arguments)},upload:function(e){return!!c.open(e)&&p.start(e)},retry:function(e){return s&&(o._getFileState(e).temp.ignoreFailure=!1),c.isUsingConnection(e)?p.start(e):r.upload(e)},cancel:function(e){var t=o.cancel(e);qq.isGenericPromise(t)?t.then(function(){p.cancel(e)}):t!==!1&&p.cancel(e)},cancelAll:function(){var e,t=c.getWaitingOrConnected();if(t.length)for(e=t.length-1;e>=0;e--)r.cancel(t[e]);c.reset()},getFile:function(e){return o.getProxy&&o.getProxy(e)?o.getProxy(e).referenceBlob:o.getFile&&o.getFile(e)},isProxied:function(e){return!(!o.getProxy||!o.getProxy(e))},getInput:function(e){if(o.getInput)return o.getInput(e)},reset:function(){i("Resetting upload handler"),r.cancelAll(),c.reset(),o.reset()},expunge:function(e){if(r.isValid(e))return o.expunge(e)},isValid:function(e){return o.isValid(e)},getResumableFilesData:function(){return o.getResumableFilesData?o.getResumableFilesData():[]},getThirdPartyFileId:function(e){if(r.isValid(e))return o.getThirdPartyFileId(e)},pause:function(e){
return!!(r.isResumable(e)&&o.pause&&r.isValid(e)&&o.pause(e))&&(c.free(e),o.moveInProgressToRemaining(e),!0)},isResumable:function(e){return!!o.isResumable&&o.isResumable(e)}}),qq.extend(l,e),i=l.log,a=l.chunking.enabled&&qq.supportedFeatures.chunking,s=a&&l.chunking.concurrent.enabled,n=function(){var e={};return e[l.preventRetryParam]=!0,e}(),p.initHandler()},qq.FormUploadHandler=function(e){"use strict";function t(e){delete c[e],p&&(clearTimeout(d[e]),delete d[e],m.stopReceivingMessages(e));var t=document.getElementById(a._getIframeName(e));t&&(t.setAttribute("src","javascript:false;"),qq(t).remove())}function n(e){return e.split("_")[0]}function i(e){var t=qq.toElement("<iframe src='javascript:false;' name='"+e+"' />");return t.setAttribute("id",e),t.style.display="none",document.body.appendChild(t),t}function o(e,t){var i=e.id,o=n(i),r=q(o);u[r]=t,c[o]=qq(e).attach("load",function(){a.getInput(o)&&(f("Received iframe load event for CORS upload request (iframe name "+i+")"),d[i]=setTimeout(function(){var e="No valid message received from loaded iframe for iframe name "+i;f(e,"error"),t({error:e})},1e3))}),m.receiveMessage(i,function(e){f("Received the following window message: '"+e+"'");var t,o=(n(i),a._parseJsonResponse(e)),r=o.uuid;r&&u[r]?(f("Handling response for iframe name "+i),clearTimeout(d[i]),delete d[i],a._detachLoadEvent(i),t=u[r],delete u[r],m.stopReceivingMessages(i),t(o)):r||f("'"+e+"' does not contain a UUID - ignoring.")})}var r=e.options,a=this,s=e.proxy,l=qq.getUniqueId(),u={},c={},d={},p=r.isCors,h=r.inputName,q=s.getUuid,f=s.log,m=new qq.WindowReceiveMessage({log:f});qq.extend(this,new qq.UploadHandler(e)),qq.override(this,function(e){return{add:function(t,n){e.add(t,{input:n}),n.setAttribute("name",h),n.parentNode&&qq(n).remove()},expunge:function(n){t(n),e.expunge(n)},isValid:function(t){return e.isValid(t)&&void 0!==a._getFileState(t).input}}}),qq.extend(this,{getInput:function(e){return a._getFileState(e).input},_attachLoadEvent:function(e,t){var n;p?o(e,t):c[e.id]=qq(e).attach("load",function(){if(f("Received response for "+e.id),e.parentNode){try{if(e.contentDocument&&e.contentDocument.body&&"false"==e.contentDocument.body.innerHTML)return}catch(i){f("Error when attempting to access iframe during handling of upload response ("+i.message+")","error"),n={success:!1}}t(n)}})},_createIframe:function(e){var t=a._getIframeName(e);return i(t)},_detachLoadEvent:function(e){void 0!==c[e]&&(c[e](),delete c[e])},_getIframeName:function(e){return e+"_"+l},_initFormForUpload:function(e){var t=e.method,n=e.endpoint,i=e.params,o=e.paramsInBody,r=e.targetName,a=qq.toElement("<form method='"+t+"' enctype='multipart/form-data'></form>"),s=n;return o?qq.obj2Inputs(i,a):s=qq.obj2url(i,n),a.setAttribute("action",s),a.setAttribute("target",r),a.style.display="none",document.body.appendChild(a),a},_parseJsonResponse:function(e){var t={};try{t=qq.parseJson(e)}catch(n){f("Error when attempting to parse iframe upload response ("+n.message+")","error")}return t}})},qq.XhrUploadHandler=function(e){"use strict";function t(e){qq.each(n._getXhrs(e),function(t,i){var o=n._getAjaxRequester(e,t);i.onreadystatechange=null,i.upload.onprogress=null,i.abort(),o&&o.canceled&&o.canceled(e)})}var n=this,i=e.options.namespace,o=e.proxy,r=e.options.chunking,a=e.options.resume,s=r&&e.options.chunking.enabled&&qq.supportedFeatures.chunking,l=a&&e.options.resume.enabled&&s&&qq.supportedFeatures.resume,u=o.getName,c=o.getSize,d=o.getUuid,p=o.getEndpoint,h=o.getDataByUuid,q=o.onUuidChanged,f=o.onProgress,m=o.log;qq.extend(this,new qq.UploadHandler(e)),qq.override(this,function(e){return{add:function(t,i){if(qq.isFile(i)||qq.isBlob(i))e.add(t,{file:i});else{if(!(i instanceof qq.BlobProxy))throw new Error("Passed obj is not a File, Blob, or proxy");e.add(t,{proxy:i})}n._initTempState(t),l&&n._maybePrepareForResume(t)},expunge:function(i){t(i),n._maybeDeletePersistedChunkData(i),n._clearXhrs(i),e.expunge(i)}}}),qq.extend(this,{clearCachedChunk:function(e,t){delete n._getFileState(e).temp.cachedChunks[t]},clearXhr:function(e,t){var i=n._getFileState(e).temp;i.xhrs&&delete i.xhrs[t],i.ajaxRequesters&&delete i.ajaxRequesters[t]},finalizeChunks:function(e,t){var i=n._getTotalChunks(e)-1,o=n._getXhr(e,i);return t?(new qq.Promise).success(t(o),o):(new qq.Promise).success({},o)},getFile:function(e){return n.isValid(e)&&n._getFileState(e).file},getProxy:function(e){return n.isValid(e)&&n._getFileState(e).proxy},getResumableFilesData:function(){var e=[];return n._iterateResumeRecords(function(t,i){n.moveInProgressToRemaining(null,i.chunking.inProgress,i.chunking.remaining);var o={name:i.name,remaining:i.chunking.remaining,size:i.size,uuid:i.uuid};i.key&&(o.key=i.key),e.push(o)}),e},isResumable:function(e){return!!r&&n.isValid(e)&&!n._getFileState(e).notResumable},moveInProgressToRemaining:function(e,t,i){var o=t||n._getFileState(e).chunking.inProgress,r=i||n._getFileState(e).chunking.remaining;o&&(m(qq.format("Moving these chunks from in-progress {}, to remaining.",JSON.stringify(o))),o.reverse(),qq.each(o,function(e,t){r.unshift(t)}),o.length=0)},pause:function(e){if(n.isValid(e))return m(qq.format("Aborting XHR upload for {} '{}' due to pause instruction.",e,u(e))),n._getFileState(e).paused=!0,t(e),!0},reevaluateChunking:function(e){if(r&&n.isValid(e)){var t,i,o=n._getFileState(e);if(delete o.chunking,o.chunking={},t=n._getTotalChunks(e),t>1||r.mandatory){for(o.chunking.enabled=!0,o.chunking.parts=t,o.chunking.remaining=[],i=0;i<t;i++)o.chunking.remaining.push(i);n._initTempState(e)}else o.chunking.enabled=!1}},updateBlob:function(e,t){n.isValid(e)&&(n._getFileState(e).file=t)},_clearXhrs:function(e){var t=n._getFileState(e).temp;qq.each(t.ajaxRequesters,function(e){delete t.ajaxRequesters[e]}),qq.each(t.xhrs,function(e){delete t.xhrs[e]})},_createXhr:function(e,t){return n._registerXhr(e,t,qq.createXhrInstance())},_getAjaxRequester:function(e,t){var i=null==t?-1:t;return n._getFileState(e).temp.ajaxRequesters[i]},_getChunkData:function(e,t){var i=r.partSize,o=c(e),a=n.getFile(e),s=i*t,l=s+i>=o?o:s+i,u=n._getTotalChunks(e),d=this._getFileState(e).temp.cachedChunks,p=d[t]||qq.sliceBlob(a,s,l);return d[t]=p,{part:t,start:s,end:l,count:u,blob:p,size:l-s}},_getChunkDataForCallback:function(e){return{partIndex:e.part,startByte:e.start+1,endByte:e.end,totalParts:e.count}},_getLocalStorageId:function(e){var t="5.0",n=u(e),o=c(e),a=r.partSize,s=p(e);return qq.format("qq{}resume{}-{}-{}-{}-{}",i,t,n,o,a,s)},_getMimeType:function(e){return n.getFile(e).type},_getPersistableData:function(e){return n._getFileState(e).chunking},_getTotalChunks:function(e){if(r){var t=c(e),n=r.partSize;return Math.ceil(t/n)}},_getXhr:function(e,t){var i=null==t?-1:t;return n._getFileState(e).temp.xhrs[i]},_getXhrs:function(e){return n._getFileState(e).temp.xhrs},_iterateResumeRecords:function(e){l&&qq.each(localStorage,function(t,n){if(0===t.indexOf(qq.format("qq{}resume",i))){var o=JSON.parse(n);e(t,o)}})},_initTempState:function(e){n._getFileState(e).temp={ajaxRequesters:{},chunkProgress:{},xhrs:{},cachedChunks:{}}},_markNotResumable:function(e){n._getFileState(e).notResumable=!0},_maybeDeletePersistedChunkData:function(e){var t;return!!(l&&n.isResumable(e)&&(t=n._getLocalStorageId(e),t&&localStorage.getItem(t)))&&(localStorage.removeItem(t),!0)},_maybePrepareForResume:function(e){var t,i,o=n._getFileState(e);l&&void 0===o.key&&(t=n._getLocalStorageId(e),i=localStorage.getItem(t),i&&(i=JSON.parse(i),h(i.uuid)?n._markNotResumable(e):(m(qq.format("Identified file with ID {} and name of {} as resumable.",e,u(e))),q(e,i.uuid),o.key=i.key,o.chunking=i.chunking,o.loaded=i.loaded,o.attemptingResume=!0,n.moveInProgressToRemaining(e))))},_maybePersistChunkedState:function(e){var t,i,o=n._getFileState(e);if(l&&n.isResumable(e)){t=n._getLocalStorageId(e),i={name:u(e),size:c(e),uuid:d(e),key:o.key,chunking:o.chunking,loaded:o.loaded,lastUpdated:Date.now()};try{localStorage.setItem(t,JSON.stringify(i))}catch(r){m(qq.format("Unable to save resume data for '{}' due to error: '{}'.",e,r.toString()),"warn")}}},_registerProgressHandler:function(e,t,i){var o=n._getXhr(e,t),r=u(e),a={simple:function(t,n){var i=c(e);t===n?f(e,r,i,i):f(e,r,t>=i?i-1:t,i)},chunked:function(o,a){var s=n._getFileState(e).temp.chunkProgress,l=n._getFileState(e).loaded,u=o,d=a,p=c(e),h=u-(d-i),q=l;s[t]=h,qq.each(s,function(e,t){q+=t}),f(e,r,q,p)}};o.upload.onprogress=function(e){if(e.lengthComputable){var t=null==i?"simple":"chunked";a[t](e.loaded,e.total)}}},_registerXhr:function(e,t,i,o){var r=null==t?-1:t,a=n._getFileState(e).temp;return a.xhrs=a.xhrs||{},a.ajaxRequesters=a.ajaxRequesters||{},a.xhrs[r]=i,o&&(a.ajaxRequesters[r]=o),i},_removeExpiredChunkingRecords:function(){var e=a.recordsExpireIn;n._iterateResumeRecords(function(t,n){var i=new Date(n.lastUpdated);i.setDate(i.getDate()+e),i.getTime()<=Date.now()&&(m("Removing expired resume record with key "+t),localStorage.removeItem(t))})},_shouldChunkThisFile:function(e){var t=n._getFileState(e);return t.chunking||n.reevaluateChunking(e),t.chunking.enabled}})},qq.WindowReceiveMessage=function(e){"use strict";var t={log:function(e,t){}},n={};qq.extend(t,e),qq.extend(this,{receiveMessage:function(e,t){var i=function(e){t(e.data)};window.postMessage?n[e]=qq(window).attach("message",i):log("iframe message passing not supported in this browser!","error")},stopReceivingMessages:function(e){if(window.postMessage){var t=n[e];t&&t()}}})},function(){"use strict";qq.uiPublicApi={addInitialFiles:function(e){this._parent.prototype.addInitialFiles.apply(this,arguments),this._templating.addCacheToDom()},clearStoredFiles:function(){this._parent.prototype.clearStoredFiles.apply(this,arguments),this._templating.clearFiles()},addExtraDropzone:function(e){this._dnd&&this._dnd.setupExtraDropzone(e)},removeExtraDropzone:function(e){if(this._dnd)return this._dnd.removeDropzone(e)},getItemByFileId:function(e){if(!this._templating.isHiddenForever(e))return this._templating.getFileContainer(e)},reset:function(){this._parent.prototype.reset.apply(this,arguments),this._templating.reset(),!this._options.button&&this._templating.getButton()&&(this._defaultButtonId=this._createUploadButton({element:this._templating.getButton(),title:this._options.text.fileInputTitle}).getButtonId()),this._dnd&&(this._dnd.dispose(),this._dnd=this._setupDragAndDrop()),this._totalFilesInBatch=0,this._filesInBatchAddedToUi=0,this._setupClickAndEditEventHandlers()},setName:function(e,t){var n=this._options.formatFileName(t);this._parent.prototype.setName.apply(this,arguments),this._templating.updateFilename(e,n)},pauseUpload:function(e){var t=this._parent.prototype.pauseUpload.apply(this,arguments);return t&&this._templating.uploadPaused(e),t},continueUpload:function(e){var t=this._parent.prototype.continueUpload.apply(this,arguments);return t&&this._templating.uploadContinued(e),t},getId:function(e){return this._templating.getFileId(e)},getDropTarget:function(e){var t=this.getFile(e);return t.qqDropTarget}},qq.uiPrivateApi={_getButton:function(e){var t=this._parent.prototype._getButton.apply(this,arguments);return t||e===this._defaultButtonId&&(t=this._templating.getButton()),t},_removeFileItem:function(e){this._templating.removeFile(e)},_setupClickAndEditEventHandlers:function(){this._fileButtonsClickHandler=qq.FileButtonsClickHandler&&this._bindFileButtonsClickEvent(),this._focusinEventSupported=!qq.firefox(),this._isEditFilenameEnabled()&&(this._filenameClickHandler=this._bindFilenameClickEvent(),this._filenameInputFocusInHandler=this._bindFilenameInputFocusInEvent(),this._filenameInputFocusHandler=this._bindFilenameInputFocusEvent())},_setupDragAndDrop:function(){var e=this,t=this._options.dragAndDrop.extraDropzones,n=this._templating,i=n.getDropZone();return i&&t.push(i),new qq.DragAndDrop({dropZoneElements:t,allowMultipleItems:this._options.multiple,classes:{dropActive:this._options.classes.dropActive},callbacks:{processingDroppedFiles:function(){n.showDropProcessing()},processingDroppedFilesComplete:function(t,i){n.hideDropProcessing(),qq.each(t,function(e,t){t.qqDropTarget=i}),t.length&&e.addFiles(t,null,null)},dropError:function(t,n){e._itemError(t,n)},dropLog:function(t,n){e.log(t,n)}}})},_bindFileButtonsClickEvent:function(){var e=this;return new qq.FileButtonsClickHandler({templating:this._templating,log:function(t,n){e.log(t,n)},onDeleteFile:function(t){e.deleteFile(t)},onCancel:function(t){e.cancel(t)},onRetry:function(t){e.retry(t)},onPause:function(t){e.pauseUpload(t)},onContinue:function(t){e.continueUpload(t)},onGetName:function(t){return e.getName(t)}})},_isEditFilenameEnabled:function(){return this._templating.isEditFilenamePossible()&&!this._options.autoUpload&&qq.FilenameClickHandler&&qq.FilenameInputFocusHandler&&qq.FilenameInputFocusHandler},_filenameEditHandler:function(){var e=this,t=this._templating;return{templating:t,log:function(t,n){e.log(t,n)},onGetUploadStatus:function(t){return e.getUploads({id:t}).status},onGetName:function(t){return e.getName(t)},onSetName:function(t,n){e.setName(t,n)},onEditingStatusChange:function(e,n){var i=qq(t.getEditInput(e)),o=qq(t.getFileContainer(e));n?(i.addClass("qq-editing"),t.hideFilename(e),t.hideEditIcon(e)):(i.removeClass("qq-editing"),t.showFilename(e),t.showEditIcon(e)),o.addClass("qq-temp").removeClass("qq-temp")}}},_onUploadStatusChange:function(e,t,n){this._parent.prototype._onUploadStatusChange.apply(this,arguments),this._isEditFilenameEnabled()&&this._templating.getFileContainer(e)&&n!==qq.status.SUBMITTED&&(this._templating.markFilenameEditable(e),this._templating.hideEditIcon(e)),n===qq.status.UPLOAD_RETRYING?(this._templating.hideRetry(e),this._templating.setStatusText(e),qq(this._templating.getFileContainer(e)).removeClass(this._classes.retrying)):n===qq.status.UPLOAD_FAILED&&this._templating.hidePause(e)},_bindFilenameInputFocusInEvent:function(){var e=qq.extend({},this._filenameEditHandler());return new qq.FilenameInputFocusInHandler(e)},_bindFilenameInputFocusEvent:function(){var e=qq.extend({},this._filenameEditHandler());return new qq.FilenameInputFocusHandler(e)},_bindFilenameClickEvent:function(){var e=qq.extend({},this._filenameEditHandler());return new qq.FilenameClickHandler(e)},_storeForLater:function(e){this._parent.prototype._storeForLater.apply(this,arguments),this._templating.hideSpinner(e)},_onAllComplete:function(e,t){this._parent.prototype._onAllComplete.apply(this,arguments),this._templating.resetTotalProgress()},_onSubmit:function(e,t){var n=this.getFile(e);n&&n.qqPath&&this._options.dragAndDrop.reportDirectoryPaths&&this._paramsStore.addReadOnly(e,{qqpath:n.qqPath}),this._parent.prototype._onSubmit.apply(this,arguments),this._addToList(e,t)},_onSubmitted:function(e){this._isEditFilenameEnabled()&&(this._templating.markFilenameEditable(e),this._templating.showEditIcon(e),this._focusinEventSupported||this._filenameInputFocusHandler.addHandler(this._templating.getEditInput(e)))},_onProgress:function(e,t,n,i){this._parent.prototype._onProgress.apply(this,arguments),this._templating.updateProgress(e,n,i),100===Math.round(n/i*100)?(this._templating.hideCancel(e),this._templating.hidePause(e),this._templating.hideProgress(e),this._templating.setStatusText(e,this._options.text.waitingForResponse),this._displayFileSize(e)):this._displayFileSize(e,n,i)},_onTotalProgress:function(e,t){this._parent.prototype._onTotalProgress.apply(this,arguments),this._templating.updateTotalProgress(e,t)},_onComplete:function(e,t,n,i){function o(t){s&&(a.setStatusText(e),qq(s).removeClass(l._classes.retrying),a.hideProgress(e),l.getUploads({id:e}).status!==qq.status.UPLOAD_FAILED&&a.hideCancel(e),a.hideSpinner(e),t.success?l._markFileAsSuccessful(e):(qq(s).addClass(l._classes.fail),a.showCancel(e),a.isRetryPossible()&&!l._preventRetries[e]&&(qq(s).addClass(l._classes.retryable),a.showRetry(e)),l._controlFailureTextDisplay(e,t)))}var r=this._parent.prototype._onComplete.apply(this,arguments),a=this._templating,s=a.getFileContainer(e),l=this;return r instanceof qq.Promise?r.done(function(e){o(e)}):o(n),r},_markFileAsSuccessful:function(e){var t=this._templating;this._isDeletePossible()&&t.showDeleteButton(e),qq(t.getFileContainer(e)).addClass(this._classes.success),this._maybeUpdateThumbnail(e)},_onUploadPrep:function(e){this._parent.prototype._onUploadPrep.apply(this,arguments),this._templating.showSpinner(e)},_onUpload:function(e,t){var n=this._parent.prototype._onUpload.apply(this,arguments);return this._templating.showSpinner(e),n},_onUploadChunk:function(e,t){this._parent.prototype._onUploadChunk.apply(this,arguments),t.partIndex>0&&this._handler.isResumable(e)&&this._templating.allowPause(e)},_onCancel:function(e,t){this._parent.prototype._onCancel.apply(this,arguments),this._removeFileItem(e),0===this._getNotFinished()&&this._templating.resetTotalProgress()},_onBeforeAutoRetry:function(e){var t,n,i;this._parent.prototype._onBeforeAutoRetry.apply(this,arguments),this._showCancelLink(e),this._options.retry.showAutoRetryNote&&(t=this._autoRetries[e],n=this._options.retry.maxAutoAttempts,i=this._options.retry.autoRetryNote.replace(/\{retryNum\}/g,t),i=i.replace(/\{maxAuto\}/g,n),this._templating.setStatusText(e,i),qq(this._templating.getFileContainer(e)).addClass(this._classes.retrying))},_onBeforeManualRetry:function(e){return this._parent.prototype._onBeforeManualRetry.apply(this,arguments)?(this._templating.resetProgress(e),qq(this._templating.getFileContainer(e)).removeClass(this._classes.fail),this._templating.setStatusText(e),this._templating.showSpinner(e),this._showCancelLink(e),!0):(qq(this._templating.getFileContainer(e)).addClass(this._classes.retryable),this._templating.showRetry(e),!1)},_onSubmitDelete:function(e){var t=qq.bind(this._onSubmitDeleteSuccess,this);this._parent.prototype._onSubmitDelete.call(this,e,t)},_onSubmitDeleteSuccess:function(e,t,n){this._options.deleteFile.forceConfirm?this._showDeleteConfirm.apply(this,arguments):this._sendDeleteRequest.apply(this,arguments)},_onDeleteComplete:function(e,t,n){this._parent.prototype._onDeleteComplete.apply(this,arguments),this._templating.hideSpinner(e),n?(this._templating.setStatusText(e,this._options.deleteFile.deletingFailedText),this._templating.showDeleteButton(e)):this._removeFileItem(e)},_sendDeleteRequest:function(e,t,n){this._templating.hideDeleteButton(e),this._templating.showSpinner(e),this._templating.setStatusText(e,this._options.deleteFile.deletingStatusText),this._deleteHandler.sendDelete.apply(this,arguments)},_showDeleteConfirm:function(e,t,n){var i,o=this.getName(e),r=this._options.deleteFile.confirmMessage.replace(/\{filename\}/g,o),a=(this.getUuid(e),arguments),s=this;i=this._options.showConfirm(r),qq.isGenericPromise(i)?i.then(function(){s._sendDeleteRequest.apply(s,a)}):i!==!1&&s._sendDeleteRequest.apply(s,a)},_addToList:function(e,t,n){var i,o,r=0,a=this._handler.isProxied(e)&&this._options.scaling.hideScaled;this._options.display.prependFiles&&(this._totalFilesInBatch>1&&this._filesInBatchAddedToUi>0&&(r=this._filesInBatchAddedToUi-1),i={index:r}),n||(this._options.disableCancelForFormUploads&&!qq.supportedFeatures.ajaxUploading&&this._templating.disableCancel(),this._options.multiple||(o=this.getUploads({id:e}),this._handledProxyGroup=this._handledProxyGroup||o.proxyGroupId,o.proxyGroupId===this._handledProxyGroup&&o.proxyGroupId||(this._handler.cancelAll(),this._clearList(),this._handledProxyGroup=null))),n?(this._templating.addFileToCache(e,this._options.formatFileName(t),i,a),this._templating.updateThumbnail(e,this._thumbnailUrls[e],!0,this._options.thumbnails.customResizer)):(this._templating.addFile(e,this._options.formatFileName(t),i,a),this._templating.generatePreview(e,this.getFile(e),this._options.thumbnails.customResizer)),this._filesInBatchAddedToUi+=1,(n||this._options.display.fileSizeOnSubmit&&qq.supportedFeatures.ajaxUploading)&&this._displayFileSize(e)},_clearList:function(){this._templating.clearFiles(),this.clearStoredFiles()},_displayFileSize:function(e,t,n){var i=this.getSize(e),o=this._formatSize(i);i>=0&&(void 0!==t&&void 0!==n&&(o=this._formatProgress(t,n)),this._templating.updateSize(e,o))},_formatProgress:function(e,t){function n(e,t){i=i.replace(e,t)}var i=this._options.text.formatProgress;return n("{percent}",Math.round(e/t*100)),n("{total_size}",this._formatSize(t)),i},_controlFailureTextDisplay:function(e,t){var n,i,o;n=this._options.failedUploadTextDisplay.mode,i=this._options.failedUploadTextDisplay.responseProperty,"custom"===n?(o=t[i],o||(o=this._options.text.failUpload),this._templating.setStatusText(e,o),this._options.failedUploadTextDisplay.enableTooltip&&this._showTooltip(e,o)):"default"===n?this._templating.setStatusText(e,this._options.text.failUpload):"none"!==n&&this.log("failedUploadTextDisplay.mode value of '"+n+"' is not valid","warn")},_showTooltip:function(e,t){this._templating.getFileContainer(e).title=t},_showCancelLink:function(e){this._options.disableCancelForFormUploads&&!qq.supportedFeatures.ajaxUploading||this._templating.showCancel(e)},_itemError:function(e,t,n){var i=this._parent.prototype._itemError.apply(this,arguments);this._options.showMessage(i)},_batchError:function(e){this._parent.prototype._batchError.apply(this,arguments),this._options.showMessage(e)},_setupPastePrompt:function(){var e=this;this._options.callbacks.onPasteReceived=function(){var t=e._options.paste.namePromptMessage,n=e._options.paste.defaultName;return e._options.showPrompt(t,n)}},_fileOrBlobRejected:function(e,t){this._totalFilesInBatch-=1,this._parent.prototype._fileOrBlobRejected.apply(this,arguments)},_prepareItemsForUpload:function(e,t,n){this._totalFilesInBatch=e.length,this._filesInBatchAddedToUi=0,this._parent.prototype._prepareItemsForUpload.apply(this,arguments)},_maybeUpdateThumbnail:function(e){var t=this._thumbnailUrls[e],n=this.getUploads({id:e}).status;n===qq.status.DELETED||!t&&!this._options.thumbnails.placeholders.waitUntilResponse&&qq.supportedFeatures.imagePreviews||this._templating.updateThumbnail(e,t,this._options.thumbnails.customResizer)},_addCannedFile:function(e){var t=this._parent.prototype._addCannedFile.apply(this,arguments);return this._addToList(t,this.getName(t),!0),this._templating.hideSpinner(t),this._templating.hideCancel(t),this._markFileAsSuccessful(t),t},_setSize:function(e,t){this._parent.prototype._setSize.apply(this,arguments),this._templating.updateSize(e,this._formatSize(t))},_sessionRequestComplete:function(){this._templating.addCacheToDom(),this._parent.prototype._sessionRequestComplete.apply(this,arguments)}}}(),qq.FineUploader=function(e,t){"use strict";var n=this;this._parent=t?qq[t].FineUploaderBasic:qq.FineUploaderBasic,this._parent.apply(this,arguments),qq.extend(this._options,{element:null,button:null,listElement:null,dragAndDrop:{extraDropzones:[],reportDirectoryPaths:!1},text:{formatProgress:"{percent}% of {total_size}",failUpload:"Upload failed",waitingForResponse:"Processing...",paused:"Paused"},template:"qq-template",classes:{retrying:"qq-upload-retrying",retryable:"qq-upload-retryable",success:"qq-upload-success",fail:"qq-upload-fail",editable:"qq-editable",hide:"qq-hide",dropActive:"qq-upload-drop-area-active"},failedUploadTextDisplay:{mode:"default",responseProperty:"error",enableTooltip:!0},messages:{tooManyFilesError:"You may only drop one file",unsupportedBrowser:"Unrecoverable error - this browser does not permit file uploading of any kind."},retry:{showAutoRetryNote:!0,autoRetryNote:"Retrying {retryNum}/{maxAuto}..."},deleteFile:{forceConfirm:!1,confirmMessage:"Are you sure you want to delete {filename}?",deletingStatusText:"Deleting...",deletingFailedText:"Delete failed"},display:{fileSizeOnSubmit:!1,prependFiles:!1},paste:{promptForName:!1,namePromptMessage:"Please name this image"},thumbnails:{customResizer:null,maxCount:0,placeholders:{waitUntilResponse:!1,notAvailablePath:null,waitingPath:null},timeBetweenThumbs:750},scaling:{hideScaled:!1},showMessage:function(e){return n._templating.hasDialog("alert")?n._templating.showDialog("alert",e):void setTimeout(function(){window.alert(e)},0)},showConfirm:function(e){return n._templating.hasDialog("confirm")?n._templating.showDialog("confirm",e):window.confirm(e)},showPrompt:function(e,t){return n._templating.hasDialog("prompt")?n._templating.showDialog("prompt",e,t):window.prompt(e,t)}},!0),qq.extend(this._options,e,!0),this._templating=new qq.Templating({log:qq.bind(this.log,this),templateIdOrEl:this._options.template,containerEl:this._options.element,fileContainerEl:this._options.listElement,button:this._options.button,imageGenerator:this._imageGenerator,classes:{hide:this._options.classes.hide,editable:this._options.classes.editable},limits:{maxThumbs:this._options.thumbnails.maxCount,timeBetweenThumbs:this._options.thumbnails.timeBetweenThumbs},placeholders:{waitUntilUpdate:this._options.thumbnails.placeholders.waitUntilResponse,thumbnailNotAvailable:this._options.thumbnails.placeholders.notAvailablePath,waitingForThumbnail:this._options.thumbnails.placeholders.waitingPath},text:this._options.text}),this._options.workarounds.ios8SafariUploads&&qq.ios800()&&qq.iosSafari()?this._templating.renderFailure(this._options.messages.unsupportedBrowserIos8Safari):!qq.supportedFeatures.uploading||this._options.cors.expected&&!qq.supportedFeatures.uploadCors?this._templating.renderFailure(this._options.messages.unsupportedBrowser):(this._wrapCallbacks(),this._templating.render(),this._classes=this._options.classes,!this._options.button&&this._templating.getButton()&&(this._defaultButtonId=this._createUploadButton({element:this._templating.getButton(),title:this._options.text.fileInputTitle}).getButtonId()),this._setupClickAndEditEventHandlers(),qq.DragAndDrop&&qq.supportedFeatures.fileDrop&&(this._dnd=this._setupDragAndDrop()),this._options.paste.targetElement&&this._options.paste.promptForName&&(qq.PasteSupport?this._setupPastePrompt():this.log("Paste support module not found.","error")),this._totalFilesInBatch=0,this._filesInBatchAddedToUi=0)},qq.extend(qq.FineUploader.prototype,qq.basePublicApi),qq.extend(qq.FineUploader.prototype,qq.basePrivateApi),qq.extend(qq.FineUploader.prototype,qq.uiPublicApi),qq.extend(qq.FineUploader.prototype,qq.uiPrivateApi),qq.Templating=function(e){"use strict";var t,n,i,o,r,a,s,l,u="qq-file-id",c="qq-file-id-",d="qq-max-size",p="qq-server-scale",h="qq-hide-dropzone",q="qq-drop-area-text",f="qq-in-progress",m="qq-hidden-forever",g={content:document.createDocumentFragment(),map:{}},_=!1,v=0,b=!1,y=[],S=-1,w={log:null,limits:{maxThumbs:0,timeBetweenThumbs:750},templateIdOrEl:"qq-template",containerEl:null,fileContainerEl:null,button:null,imageGenerator:null,classes:{hide:"qq-hide",editable:"qq-editable"},placeholders:{waitUntilUpdate:!1,thumbnailNotAvailable:null,waitingForThumbnail:null},text:{paused:"Paused"}},F={button:"qq-upload-button-selector",alertDialog:"qq-alert-dialog-selector",dialogCancelButton:"qq-cancel-button-selector",confirmDialog:"qq-confirm-dialog-selector",dialogMessage:"qq-dialog-message-selector",dialogOkButton:"qq-ok-button-selector",promptDialog:"qq-prompt-dialog-selector",uploader:"qq-uploader-selector",drop:"qq-upload-drop-area-selector",list:"qq-upload-list-selector",progressBarContainer:"qq-progress-bar-container-selector",progressBar:"qq-progress-bar-selector",totalProgressBarContainer:"qq-total-progress-bar-container-selector",totalProgressBar:"qq-total-progress-bar-selector",file:"qq-upload-file-selector",spinner:"qq-upload-spinner-selector",size:"qq-upload-size-selector",cancel:"qq-upload-cancel-selector",pause:"qq-upload-pause-selector",continueButton:"qq-upload-continue-selector",deleteButton:"qq-upload-delete-selector",retry:"qq-upload-retry-selector",statusText:"qq-upload-status-text-selector",editFilenameInput:"qq-edit-filename-selector",editNameIcon:"qq-edit-filename-icon-selector",dropText:"qq-upload-drop-area-text-selector",dropProcessing:"qq-drop-processing-selector",dropProcessingSpinner:"qq-drop-processing-spinner-selector",thumbnail:"qq-thumbnail-selector"},x={},C=new qq.Promise,E=new qq.Promise,I=function(){var e=w.placeholders.thumbnailNotAvailable,n=w.placeholders.waitingForThumbnail,i={maxSize:S,scale:l};s&&(e?w.imageGenerator.generate(e,new Image,i).then(function(e){C.success(e)},function(){C.failure(),t("Problem loading 'not available' placeholder image at "+e,"error")}):C.failure(),n?w.imageGenerator.generate(n,new Image,i).then(function(e){E.success(e)},function(){E.failure(),t("Problem loading 'waiting for thumbnail' placeholder image at "+n,"error")}):E.failure())},P=function(e){var t=new qq.Promise;return E.then(function(n){Q(n,e),e.src?t.success():(e.src=n.src,e.onload=function(){e.onload=null,te(e),t.success()})},function(){W(e),t.success()}),t},D=function(e,n,i){var o=X(e);return t("Generating new thumbnail for "+e),n.qqThumbnailId=e,w.imageGenerator.generate(n,o,i).then(function(){v++,te(o),x[e].success()},function(){x[e].failure(),w.placeholders.waitUntilUpdate||Y(e,o)})},T=function(){if(y.length){b=!0;var e=y.shift();e.update?$(e):K(e)}else b=!1},U=function(e){return V(L(e),F.cancel)},k=function(e){return V(L(e),F.continueButton)},A=function(e){return V(r,F[e+"Dialog"])},R=function(e){return V(L(e),F.deleteButton)},B=function(){return V(r,F.dropProcessing)},N=function(e){return V(L(e),F.editNameIcon)},L=function(e){return g.map[e]||qq(a).getFirstByClass(c+e)},O=function(e){return V(L(e),F.file)},H=function(e){return V(L(e),F.pause)},z=function(e){return null==e?V(r,F.totalProgressBarContainer)||V(r,F.totalProgressBar):V(L(e),F.progressBarContainer)||V(L(e),F.progressBar)},M=function(e){return V(L(e),F.retry)},j=function(e){return V(L(e),F.size)},G=function(e){return V(L(e),F.spinner)},V=function(e,t){return e&&qq(e).getFirstByClass(t)},X=function(e){return s&&V(L(e),F.thumbnail)},W=function(e){e&&qq(e).addClass(w.classes.hide)},Q=function(e,t){var n=e.style.maxWidth,i=e.style.maxHeight;i&&n&&!t.style.maxWidth&&!t.style.maxHeight&&qq(t).css({maxWidth:n,maxHeight:i})},Y=function(e,t){var n=x[e]||(new qq.Promise).failure(),i=new qq.Promise;return C.then(function(e){n.then(function(){i.success()},function(){Q(e,t),t.onload=function(){t.onload=null,i.success()},t.src=e.src,te(t)})}),i},J=function(){var e,o,r,a,u,c,f,m,g,_,v;if(t("Parsing template"),null==w.templateIdOrEl)throw new Error("You MUST specify either a template element or ID!");if(qq.isString(w.templateIdOrEl)){if(e=document.getElementById(w.templateIdOrEl),null===e)throw new Error(qq.format("Cannot find template script at ID '{}'!",w.templateIdOrEl));o=e.innerHTML}else{if(void 0===w.templateIdOrEl.innerHTML)throw new Error("You have specified an invalid value for the template option!  It must be an ID or an Element.");o=w.templateIdOrEl.innerHTML}if(o=qq.trimStr(o),a=document.createElement("div"),a.appendChild(qq.toElement(o)),v=qq(a).getFirstByClass(F.uploader),w.button&&(c=qq(a).getFirstByClass(F.button),c&&qq(c).remove()),qq.DragAndDrop&&qq.supportedFeatures.fileDrop||(g=qq(a).getFirstByClass(F.dropProcessing),g&&qq(g).remove()),f=qq(a).getFirstByClass(F.drop),f&&!qq.DragAndDrop&&(t("DnD module unavailable.","info"),qq(f).remove()),qq.supportedFeatures.fileDrop?qq(v).hasAttribute(q)&&f&&(_=qq(f).getFirstByClass(F.dropText),_&&qq(_).remove()):(v.removeAttribute(q),f&&qq(f).hasAttribute(h)&&qq(f).css({display:"none"})),m=qq(a).getFirstByClass(F.thumbnail),s?m&&(S=parseInt(m.getAttribute(d)),S=S>0?S:null,l=qq(m).hasAttribute(p)):m&&qq(m).remove(),s=s&&m,n=qq(a).getByClass(F.editFilenameInput).length>0,i=qq(a).getByClass(F.retry).length>0,r=qq(a).getFirstByClass(F.list),null==r)throw new Error("Could not find the file list container in the template!");return u=r.innerHTML,r.innerHTML="",a.getElementsByTagName("DIALOG").length&&document.createElement("dialog"),t("Template parsing complete"),{template:qq.trimStr(a.innerHTML),fileTemplate:qq.trimStr(u)}},Z=function(e,t,n){var i=n,o=i.firstChild;t>0&&(o=qq(i).children()[t].nextSibling),
i.insertBefore(e,o)},K=function(e){var t=e.id,n=e.optFileOrBlob,i=n&&n.qqThumbnailId,o=X(t),r={customResizeFunction:e.customResizeFunction,maxSize:S,orient:!0,scale:!0};qq.supportedFeatures.imagePreviews?o?w.limits.maxThumbs&&w.limits.maxThumbs<=v?(Y(t,o),T()):P(o).done(function(){x[t]=new qq.Promise,x[t].done(function(){setTimeout(T,w.limits.timeBetweenThumbs)}),null!=i?ne(t,i):D(t,n,r)}):T():o&&(P(o),T())},$=function(e){var t=e.id,n=e.thumbnailUrl,i=e.showWaitingImg,o=X(t),r={customResizeFunction:e.customResizeFunction,scale:l,maxSize:S};if(o)if(n){if(!(w.limits.maxThumbs&&w.limits.maxThumbs<=v))return i&&P(o),w.imageGenerator.generate(n,o,r).then(function(){te(o),v++,setTimeout(T,w.limits.timeBetweenThumbs)},function(){Y(t,o),setTimeout(T,w.limits.timeBetweenThumbs)});Y(t,o),T()}else Y(t,o),T()},ee=function(e,t){var n=z(e),i=null==e?F.totalProgressBar:F.progressBar;n&&!qq(n).hasClass(i)&&(n=qq(n).getFirstByClass(i)),n&&(qq(n).css({width:t+"%"}),n.setAttribute("aria-valuenow",t))},te=function(e){e&&qq(e).removeClass(w.classes.hide)},ne=function(e,n){var i=X(e),o=X(n);t(qq.format("ID {} is the same file as ID {}.  Will use generated thumbnail from ID {} instead.",e,n,n)),x[n].then(function(){v++,x[e].success(),t(qq.format("Now using previously generated thumbnail created for ID {} on ID {}.",n,e)),i.src=o.src,te(i)},function(){x[e].failure(),w.placeholders.waitUntilUpdate||Y(e,i)})};qq.extend(w,e),t=w.log,qq.supportedFeatures.imagePreviews||(w.limits.timeBetweenThumbs=0,w.limits.maxThumbs=0),r=w.containerEl,s=void 0!==w.imageGenerator,o=J(),I(),qq.extend(this,{render:function(){t("Rendering template in DOM."),v=0,r.innerHTML=o.template,W(B()),this.hideTotalProgress(),a=w.fileContainerEl||V(r,F.list),t("Template rendering complete")},renderFailure:function(e){var t=qq.toElement(e);r.innerHTML="",r.appendChild(t)},reset:function(){this.render()},clearFiles:function(){a.innerHTML=""},disableCancel:function(){_=!0},addFile:function(e,t,n,i,s){var l,d=qq.toElement(o.fileTemplate),p=V(d,F.file),h=V(r,F.uploader),f=s?g.content:a;s&&(g.map[e]=d),qq(d).addClass(c+e),h.removeAttribute(q),p&&(qq(p).setText(t),p.setAttribute("title",t)),d.setAttribute(u,e),n?Z(d,n.index,f):f.appendChild(d),i?(d.style.display="none",qq(d).addClass(m)):(W(z(e)),W(j(e)),W(R(e)),W(M(e)),W(H(e)),W(k(e)),_&&this.hideCancel(e),l=X(e),l&&!l.src&&E.then(function(e){l.src=e.src,e.style.maxHeight&&e.style.maxWidth&&qq(l).css({maxHeight:e.style.maxHeight,maxWidth:e.style.maxWidth}),te(l)}))},addFileToCache:function(e,t,n,i){this.addFile(e,t,n,i,!0)},addCacheToDom:function(){a.appendChild(g.content),g.content=document.createDocumentFragment(),g.map={}},removeFile:function(e){qq(L(e)).remove()},getFileId:function(e){var t=e;if(t){for(;null==t.getAttribute(u);)t=t.parentNode;return parseInt(t.getAttribute(u))}},getFileList:function(){return a},markFilenameEditable:function(e){var t=O(e);t&&qq(t).addClass(w.classes.editable)},updateFilename:function(e,t){var n=O(e);n&&(qq(n).setText(t),n.setAttribute("title",t))},hideFilename:function(e){W(O(e))},showFilename:function(e){te(O(e))},isFileName:function(e){return qq(e).hasClass(F.file)},getButton:function(){return w.button||V(r,F.button)},hideDropProcessing:function(){W(B())},showDropProcessing:function(){te(B())},getDropZone:function(){return V(r,F.drop)},isEditFilenamePossible:function(){return n},hideRetry:function(e){W(M(e))},isRetryPossible:function(){return i},showRetry:function(e){te(M(e))},getFileContainer:function(e){return L(e)},showEditIcon:function(e){var t=N(e);t&&qq(t).addClass(w.classes.editable)},isHiddenForever:function(e){return qq(L(e)).hasClass(m)},hideEditIcon:function(e){var t=N(e);t&&qq(t).removeClass(w.classes.editable)},isEditIcon:function(e){return qq(e).hasClass(F.editNameIcon,!0)},getEditInput:function(e){return V(L(e),F.editFilenameInput)},isEditInput:function(e){return qq(e).hasClass(F.editFilenameInput,!0)},updateProgress:function(e,t,n){var i,o=z(e);o&&n>0&&(i=Math.round(t/n*100),100===i?W(o):te(o),ee(e,i))},updateTotalProgress:function(e,t){this.updateProgress(null,e,t)},hideProgress:function(e){var t=z(e);t&&W(t)},hideTotalProgress:function(){this.hideProgress()},resetProgress:function(e){ee(e,0),this.hideTotalProgress(e)},resetTotalProgress:function(){this.resetProgress()},showCancel:function(e){if(!_){var t=U(e);t&&qq(t).removeClass(w.classes.hide)}},hideCancel:function(e){W(U(e))},isCancel:function(e){return qq(e).hasClass(F.cancel,!0)},allowPause:function(e){te(H(e)),W(k(e))},uploadPaused:function(e){this.setStatusText(e,w.text.paused),this.allowContinueButton(e),W(G(e))},hidePause:function(e){W(H(e))},isPause:function(e){return qq(e).hasClass(F.pause,!0)},isContinueButton:function(e){return qq(e).hasClass(F.continueButton,!0)},allowContinueButton:function(e){te(k(e)),W(H(e))},uploadContinued:function(e){this.setStatusText(e,""),this.allowPause(e),te(G(e))},showDeleteButton:function(e){te(R(e))},hideDeleteButton:function(e){W(R(e))},isDeleteButton:function(e){return qq(e).hasClass(F.deleteButton,!0)},isRetry:function(e){return qq(e).hasClass(F.retry,!0)},updateSize:function(e,t){var n=j(e);n&&(te(n),qq(n).setText(t))},setStatusText:function(e,t){var n=V(L(e),F.statusText);n&&(null==t?qq(n).clearText():qq(n).setText(t))},hideSpinner:function(e){qq(L(e)).removeClass(f),W(G(e))},showSpinner:function(e){qq(L(e)).addClass(f),te(G(e))},generatePreview:function(e,t,n){this.isHiddenForever(e)||(y.push({id:e,customResizeFunction:n,optFileOrBlob:t}),!b&&T())},updateThumbnail:function(e,t,n,i){this.isHiddenForever(e)||(y.push({customResizeFunction:i,update:!0,id:e,thumbnailUrl:t,showWaitingImg:n}),!b&&T())},hasDialog:function(e){return qq.supportedFeatures.dialogElement&&!!A(e)},showDialog:function(e,t,n){var i=A(e),o=V(i,F.dialogMessage),r=i.getElementsByTagName("INPUT")[0],a=V(i,F.dialogCancelButton),s=V(i,F.dialogOkButton),l=new qq.Promise,u=function(){a.removeEventListener("click",c),s&&s.removeEventListener("click",d),l.failure()},c=function(){a.removeEventListener("click",c),i.close()},d=function(){i.removeEventListener("close",u),s.removeEventListener("click",d),i.close(),l.success(r&&r.value)};return i.addEventListener("close",u),a.addEventListener("click",c),s&&s.addEventListener("click",d),r&&(r.value=n),o.textContent=t,i.showModal(),l}})},qq.traditional=qq.traditional||{},qq.traditional.FormUploadHandler=function(e,t){"use strict";function n(e,t){var n,i,r;try{i=t.contentDocument||t.contentWindow.document,r=i.body.innerHTML,s("converting iframe's innerHTML to JSON"),s("innerHTML = "+r),r&&r.match(/^<pre/i)&&(r=i.body.firstChild.firstChild.nodeValue),n=o._parseJsonResponse(r)}catch(a){s("Error when attempting to parse form upload response ("+a.message+")","error"),n={success:!1}}return n}function i(t,n){var i=e.paramsStore.get(t),s="get"===e.method.toLowerCase()?"GET":"POST",l=e.endpointStore.get(t),u=r(t);return i[e.uuidName]=a(t),i[e.filenameParam]=u,o._initFormForUpload({method:s,endpoint:l,params:i,paramsInBody:e.paramsInBody,targetName:n.name})}var o=this,r=t.getName,a=t.getUuid,s=t.log;this.uploadFile=function(t){var r,a=o.getInput(t),l=o._createIframe(t),u=new qq.Promise;return r=i(t,l),r.appendChild(a),o._attachLoadEvent(l,function(i){s("iframe loaded");var r=i?i:n(t,l);o._detachLoadEvent(t),e.cors.expected||qq(l).remove(),r.success?u.success(r):u.failure(r)}),s("Sending upload request for "+t),r.submit(),qq(r).remove(),u},qq.extend(this,new qq.FormUploadHandler({options:{isCors:e.cors.expected,inputName:e.inputName},proxy:{onCancel:e.onCancel,getName:r,getUuid:a,log:s}}))},qq.traditional=qq.traditional||{},qq.traditional.XhrUploadHandler=function(e,t){"use strict";var n=this,i=t.getName,o=t.getSize,r=t.getUuid,a=t.log,s=e.forceMultipart||e.paramsInBody,l=function(t,n,r){var a=o(t),l=i(t);n[e.chunking.paramNames.partIndex]=r.part,n[e.chunking.paramNames.partByteOffset]=r.start,n[e.chunking.paramNames.chunkSize]=r.size,n[e.chunking.paramNames.totalParts]=r.count,n[e.totalFileSizeName]=a,s&&(n[e.filenameParam]=l)},u=new qq.traditional.AllChunksDoneAjaxRequester({cors:e.cors,endpoint:e.chunking.success.endpoint,log:a}),c=function(e,t){var n=new qq.Promise;return t.onreadystatechange=function(){if(4===t.readyState){var i=h(e,t);i.success?n.success(i.response,t):n.failure(i.response,t)}},n},d=function(t){var a=e.paramsStore.get(t),s=i(t),l=o(t);return a[e.uuidName]=r(t),a[e.filenameParam]=s,a[e.totalFileSizeName]=l,a[e.chunking.paramNames.totalParts]=n._getTotalChunks(t),a},p=function(e,t){return qq.indexOf([200,201,202,203,204],e.status)<0||!t.success||t.reset},h=function(e,t){var n;return a("xhr - server response received for "+e),a("responseText = "+t.responseText),n=q(!0,t),{success:!p(t,n),response:n}},q=function(e,t){var n={};try{a(qq.format("Received response status {} with body: {}",t.status,t.responseText)),n=qq.parseJson(t.responseText)}catch(i){e&&a("Error when attempting to parse xhr response text ("+i.message+")","error")}return n},f=function(t){var i=new qq.Promise;return u.complete(t,n._createXhr(t),d(t),e.customHeaders.get(t)).then(function(e){i.success(q(!1,e),e)},function(e){i.failure(q(!1,e),e)}),i},m=function(t,n,a,l){var u=new FormData,c=e.method,d=e.endpointStore.get(l),p=i(l),h=o(l);return t[e.uuidName]=r(l),t[e.filenameParam]=p,s&&(t[e.totalFileSizeName]=h),e.paramsInBody||(s||(t[e.inputName]=p),d=qq.obj2url(t,d)),n.open(c,d,!0),e.cors.expected&&e.cors.sendCredentials&&(n.withCredentials=!0),s?(e.paramsInBody&&qq.obj2FormData(t,u),u.append(e.inputName,a),u):a},g=function(t,i){var o=e.customHeaders.get(t),r=n.getFile(t);i.setRequestHeader("Accept","application/json"),i.setRequestHeader("X-Requested-With","XMLHttpRequest"),i.setRequestHeader("Cache-Control","no-cache"),s||(i.setRequestHeader("Content-Type","application/octet-stream"),i.setRequestHeader("X-Mime-Type",r.type)),qq.each(o,function(e,t){i.setRequestHeader(e,t)})};qq.extend(this,{uploadChunk:function(t,i,r){var a,s,u,d=n._getChunkData(t,i),p=n._createXhr(t,i);o(t);return a=c(t,p),n._registerProgressHandler(t,i,d.size),u=e.paramsStore.get(t),l(t,u,d),r&&(u[e.resume.paramNames.resuming]=!0),s=m(u,p,d.blob,t),g(t,p),p.send(s),a},uploadFile:function(t){var i,o,r,a,s=n.getFile(t);return o=n._createXhr(t),n._registerProgressHandler(t),i=c(t,o),r=e.paramsStore.get(t),a=m(r,o,s,t),g(t,o),o.send(a),i}}),qq.extend(this,new qq.XhrUploadHandler({options:qq.extend({namespace:"traditional"},e),proxy:qq.extend({getEndpoint:e.endpointStore.get},t)})),qq.override(this,function(t){return{finalizeChunks:function(n){return e.chunking.success.endpoint?f(n):t.finalizeChunks(n,qq.bind(q,this,!0))}}})},qq.traditional.AllChunksDoneAjaxRequester=function(e){"use strict";var t,n="POST",i={cors:{allowXdr:!1,expected:!1,sendCredentials:!1},endpoint:null,log:function(e,t){}},o={},r={get:function(e){return i.endpoint}};qq.extend(i,e),t=qq.extend(this,new qq.AjaxRequester({acceptHeader:"application/json",validMethods:[n],method:n,endpointStore:r,allowXRequestedWithAndCacheControl:!1,cors:i.cors,log:i.log,onComplete:function(e,t,n){var i=o[e];delete o[e],n?i.failure(t):i.success(t)}})),qq.extend(this,{complete:function(e,n,r,a){var s=new qq.Promise;return i.log("Submitting All Chunks Done request for "+e),o[e]=s,t.initTransport(e).withParams(r).withHeaders(a).send(n),s}})},qq.PasteSupport=function(e){"use strict";function t(e){return e.type&&0===e.type.indexOf("image/")}function n(){r=qq(o.targetElement).attach("paste",function(e){var n=e.clipboardData;n&&qq.each(n.items,function(e,n){if(t(n)){var i=n.getAsFile();o.callbacks.pasteReceived(i)}})})}function i(){r&&r()}var o,r;o={targetElement:null,callbacks:{log:function(e,t){},pasteReceived:function(e){}}},qq.extend(o,e),n(),qq.extend(this,{reset:function(){i()}})},qq.DragAndDrop=function(e){"use strict";function t(e,t){var n=Array.prototype.slice.call(e);u.callbacks.dropLog("Grabbed "+e.length+" dropped files."),t.dropDisabled(!1),u.callbacks.processingDroppedFilesComplete(n,t.getElement())}function n(e){var t=new qq.Promise;return e.isFile?e.file(function(n){var i=e.name,o=e.fullPath,r=o.indexOf(i);o=o.substr(0,r),"/"===o.charAt(0)&&(o=o.substr(1)),n.qqPath=o,h.push(n),t.success()},function(n){u.callbacks.dropLog("Problem parsing '"+e.fullPath+"'.  FileError code "+n.code+".","error"),t.failure()}):e.isDirectory&&i(e).then(function(e){var i=e.length;qq.each(e,function(e,o){n(o).done(function(){i-=1,0===i&&t.success()})}),e.length||t.success()},function(n){u.callbacks.dropLog("Problem parsing '"+e.fullPath+"'.  FileError code "+n.code+".","error"),t.failure()}),t}function i(e,t,n,o){var r=o||new qq.Promise,a=t||e.createReader();return a.readEntries(function(t){var o=n?n.concat(t):t;t.length?setTimeout(function(){i(e,a,o,r)},0):r.success(o)},r.failure),r}function o(e,t){var i=[],o=new qq.Promise;return u.callbacks.processingDroppedFiles(),t.dropDisabled(!0),e.files.length>1&&!u.allowMultipleItems?(u.callbacks.processingDroppedFilesComplete([]),u.callbacks.dropError("tooManyFilesError",""),t.dropDisabled(!1),o.failure()):(h=[],qq.isFolderDropSupported(e)?qq.each(e.items,function(e,t){var r=t.webkitGetAsEntry();r&&(r.isFile?h.push(t.getAsFile()):i.push(n(r).done(function(){i.pop(),0===i.length&&o.success()})))}):h=e.files,0===i.length&&o.success()),o}function r(e){var n=new qq.UploadDropZone({HIDE_ZONES_EVENT_NAME:c,element:e,onEnter:function(t){qq(e).addClass(u.classes.dropActive),t.stopPropagation()},onLeaveNotDescendants:function(t){qq(e).removeClass(u.classes.dropActive)},onDrop:function(e){o(e.dataTransfer,n).then(function(){t(h,n)},function(){u.callbacks.dropLog("Drop event DataTransfer parsing failed.  No files will be uploaded.","error")})}});return q.addDisposer(function(){n.dispose()}),qq(e).hasAttribute(d)&&qq(e).hide(),p.push(n),n}function a(e){var t;return qq.each(e.dataTransfer.types,function(e,n){if("Files"===n)return t=!0,!1}),t}function s(e){return qq.firefox()?!e.relatedTarget:qq.safari()?e.x<0||e.y<0:0===e.x&&0===e.y}function l(){var e=u.dropZoneElements,t=function(){setTimeout(function(){qq.each(e,function(e,t){qq(t).hasAttribute(d)&&qq(t).hide(),qq(t).removeClass(u.classes.dropActive)})},10)};qq.each(e,function(t,n){var i=r(n);e.length&&qq.supportedFeatures.fileDrop&&q.attach(document,"dragenter",function(t){!i.dropDisabled()&&a(t)&&qq.each(e,function(e,t){t instanceof HTMLElement&&qq(t).hasAttribute(d)&&qq(t).css({display:"block"})})})}),q.attach(document,"dragleave",function(e){s(e)&&t()}),q.attach(qq(document).children()[0],"mouseenter",function(e){t()}),q.attach(document,"drop",function(e){e.preventDefault(),t()}),q.attach(document,c,t)}var u,c="qq-hidezones",d="qq-hide-dropzone",p=[],h=[],q=new qq.DisposeSupport;u={dropZoneElements:[],allowMultipleItems:!0,classes:{dropActive:null},callbacks:new qq.DragAndDrop.callbacks},qq.extend(u,e,!0),l(),qq.extend(this,{setupExtraDropzone:function(e){u.dropZoneElements.push(e),r(e)},removeDropzone:function(e){var t,n=u.dropZoneElements;for(t in n)if(n[t]===e)return n.splice(t,1)},dispose:function(){q.dispose(),qq.each(p,function(e,t){t.dispose()})}})},qq.DragAndDrop.callbacks=function(){"use strict";return{processingDroppedFiles:function(){},processingDroppedFilesComplete:function(e,t){},dropError:function(e,t){qq.log("Drag & drop error code '"+e+" with these specifics: '"+t+"'","error")},dropLog:function(e,t){qq.log(e,t)}}},qq.UploadDropZone=function(e){"use strict";function t(){return qq.safari()||qq.firefox()&&qq.windows()}function n(e){c||(t?d.attach(document,"dragover",function(e){e.preventDefault()}):d.attach(document,"dragover",function(e){e.dataTransfer&&(e.dataTransfer.dropEffect="none",e.preventDefault())}),c=!0)}function i(e){if(!qq.supportedFeatures.fileDrop)return!1;var t,n=e.dataTransfer,i=qq.safari();return t=!(!qq.ie()||!qq.supportedFeatures.fileDrop)||"none"!==n.effectAllowed,n&&t&&(n.files||!i&&n.types.contains&&n.types.contains("Files"))}function o(e){return void 0!==e&&(u=e),u}function r(){function e(){t=document.createEvent("Event"),t.initEvent(s.HIDE_ZONES_EVENT_NAME,!0,!0)}var t;if(window.CustomEvent)try{t=new CustomEvent(s.HIDE_ZONES_EVENT_NAME)}catch(n){e()}else e();document.dispatchEvent(t)}function a(){d.attach(l,"dragover",function(e){if(i(e)){var t=qq.ie()&&qq.supportedFeatures.fileDrop?null:e.dataTransfer.effectAllowed;"move"===t||"linkMove"===t?e.dataTransfer.dropEffect="move":e.dataTransfer.dropEffect="copy",e.stopPropagation(),e.preventDefault()}}),d.attach(l,"dragenter",function(e){if(!o()){if(!i(e))return;s.onEnter(e)}}),d.attach(l,"dragleave",function(e){if(i(e)){s.onLeave(e);var t=document.elementFromPoint(e.clientX,e.clientY);qq(this).contains(t)||s.onLeaveNotDescendants(e)}}),d.attach(l,"drop",function(e){if(!o()){if(!i(e))return;e.preventDefault(),e.stopPropagation(),s.onDrop(e),r()}})}var s,l,u,c,d=new qq.DisposeSupport;s={element:null,onEnter:function(e){},onLeave:function(e){},onLeaveNotDescendants:function(e){},onDrop:function(e){}},qq.extend(s,e),l=s.element,n(),a(),qq.extend(this,{dropDisabled:function(e){return o(e)},dispose:function(){d.dispose()},getElement:function(){return l}})},qq.DeleteFileAjaxRequester=function(e){"use strict";function t(){return"POST"===i.method.toUpperCase()?{_method:"DELETE"}:{}}var n,i={method:"DELETE",uuidParamName:"qquuid",endpointStore:{},maxConnections:3,customHeaders:function(e){return{}},paramsStore:{},cors:{expected:!1,sendCredentials:!1},log:function(e,t){},onDelete:function(e){},onDeleteComplete:function(e,t,n){}};qq.extend(i,e),n=qq.extend(this,new qq.AjaxRequester({acceptHeader:"application/json",validMethods:["POST","DELETE"],method:i.method,endpointStore:i.endpointStore,paramsStore:i.paramsStore,mandatedParams:t(),maxConnections:i.maxConnections,customHeaders:function(e){return i.customHeaders.get(e)},log:i.log,onSend:i.onDelete,onComplete:i.onDeleteComplete,cors:i.cors})),qq.extend(this,{sendDelete:function(e,t,o){var r=o||{};i.log("Submitting delete file request for "+e),"DELETE"===i.method?n.initTransport(e).withPath(t).withParams(r).send():(r[i.uuidParamName]=t,n.initTransport(e).withParams(r).send())}})},function(){function e(e){var t,n=e.naturalWidth,i=e.naturalHeight,o=document.createElement("canvas");return n*i>1048576&&(o.width=o.height=1,t=o.getContext("2d"),t.drawImage(e,-n+1,0),0===t.getImageData(0,0,1,1).data[3])}function t(e,t,n){var i,o,r,a,s=document.createElement("canvas"),l=0,u=n,c=n;for(s.width=1,s.height=n,i=s.getContext("2d"),i.drawImage(e,0,0),o=i.getImageData(0,0,1,n).data;c>l;)r=o[4*(c-1)+3],0===r?u=c:l=c,c=u+l>>1;return a=c/n,0===a?1:a}function n(e,t,n,i){var r=document.createElement("canvas"),a=n.mime||"image/jpeg",s=new qq.Promise;return o(e,t,r,n,i).then(function(){s.success(r.toDataURL(a,n.quality||.8))}),s}function i(e){var t=5241e3;if(!qq.ios())throw new qq.Error("Downsampled dimensions can only be reliably calculated for iOS!");if(e.origHeight*e.origWidth>t)return{newHeight:Math.round(Math.sqrt(t*(e.origHeight/e.origWidth))),newWidth:Math.round(Math.sqrt(t*(e.origWidth/e.origHeight)))}}function o(n,o,s,l,u){var c,d=n.naturalWidth,p=n.naturalHeight,h=l.width,q=l.height,f=s.getContext("2d"),m=new qq.Promise;return f.save(),l.resize?r({blob:o,canvas:s,image:n,imageHeight:p,imageWidth:d,orientation:l.orientation,resize:l.resize,targetHeight:q,targetWidth:h}):(qq.supportedFeatures.unlimitedScaledImageSize||(c=i({origWidth:h,origHeight:q}),c&&(qq.log(qq.format("Had to reduce dimensions due to device limitations from {}w / {}h to {}w / {}h",h,q,c.newWidth,c.newHeight),"warn"),h=c.newWidth,q=c.newHeight)),a(s,h,q,l.orientation),qq.ios()?!function(){e(n)&&(d/=2,p/=2);var i,o,r,a=1024,s=document.createElement("canvas"),l=u?t(n,d,p):1,c=Math.ceil(a*h/d),m=Math.ceil(a*q/p/l),g=0,_=0;for(s.width=s.height=a,i=s.getContext("2d");g<p;){for(o=0,r=0;o<d;)i.clearRect(0,0,a,a),i.drawImage(n,-o,-g),f.drawImage(s,0,0,a,a,r,_,c,m),o+=a,r+=c;g+=a,_+=m}f.restore(),s=i=null}():f.drawImage(n,0,0,h,q),s.qqImageRendered&&s.qqImageRendered(),m.success(),m)}function r(e){var t=e.blob,n=e.image,i=e.imageHeight,o=e.imageWidth,r=e.orientation,s=new qq.Promise,l=e.resize,u=document.createElement("canvas"),c=u.getContext("2d"),d=e.canvas,p=e.targetHeight,h=e.targetWidth;return a(u,o,i,r),d.height=p,d.width=h,c.drawImage(n,0,0),l({blob:t,height:p,image:n,sourceCanvas:u,targetCanvas:d,width:h}).then(function(){d.qqImageRendered&&d.qqImageRendered(),s.success()},s.failure),s}function a(e,t,n,i){switch(i){case 5:case 6:case 7:case 8:e.width=n,e.height=t;break;default:e.width=t,e.height=n}var o=e.getContext("2d");switch(i){case 2:o.translate(t,0),o.scale(-1,1);break;case 3:o.translate(t,n),o.rotate(Math.PI);break;case 4:o.translate(0,n),o.scale(1,-1);break;case 5:o.rotate(.5*Math.PI),o.scale(1,-1);break;case 6:o.rotate(.5*Math.PI),o.translate(0,-n);break;case 7:o.rotate(.5*Math.PI),o.translate(t,-n),o.scale(-1,1);break;case 8:o.rotate(-.5*Math.PI),o.translate(-t,0)}}function s(e,t){var n=this;window.Blob&&e instanceof Blob&&!function(){var t=new Image,i=window.URL&&window.URL.createObjectURL?window.URL:window.webkitURL&&window.webkitURL.createObjectURL?window.webkitURL:null;if(!i)throw Error("No createObjectURL function found to create blob url");t.src=i.createObjectURL(e),n.blob=e,e=t}(),e.naturalWidth||e.naturalHeight||(e.onload=function(){var e=n.imageLoadListeners;e&&(n.imageLoadListeners=null,setTimeout(function(){for(var t=0,n=e.length;t<n;t++)e[t]()},0))},e.onerror=t,this.imageLoadListeners=[]),this.srcImage=e}s.prototype.render=function(e,t){t=t||{};var i,r=this,a=this.srcImage.naturalWidth,s=this.srcImage.naturalHeight,l=t.width,u=t.height,c=t.maxWidth,d=t.maxHeight,p=!this.blob||"image/jpeg"===this.blob.type,h=e.tagName.toLowerCase();return this.imageLoadListeners?void this.imageLoadListeners.push(function(){r.render(e,t)}):(l&&!u?u=s*l/a<<0:u&&!l?l=a*u/s<<0:(l=a,u=s),c&&l>c&&(l=c,u=s*l/a<<0),d&&u>d&&(u=d,l=a*u/s<<0),i={width:l,height:u},qq.each(t,function(e,t){i[e]=t}),"img"===h?!function(){var t=e.src;n(r.srcImage,r.blob,i,p).then(function(n){e.src=n,t===e.src&&e.onload()})}():"canvas"===h&&o(this.srcImage,this.blob,e,i,p),void("function"==typeof this.onrender&&this.onrender(e)))},qq.MegaPixImage=s}(),qq.ImageGenerator=function(e){"use strict";function t(e){return"img"===e.tagName.toLowerCase()}function n(e){return"canvas"===e.tagName.toLowerCase()}function i(){return void 0!==(new Image).crossOrigin}function o(){var e=document.createElement("canvas");return e.getContext&&e.getContext("2d")}function r(e){var t=e.split("/"),n=t[t.length-1],i=qq.getExtension(n);switch(i=i&&i.toLowerCase()){case"jpeg":case"jpg":return"image/jpeg";case"png":return"image/png";case"bmp":return"image/bmp";case"gif":return"image/gif";case"tiff":case"tif":return"image/tiff"}}function a(e){var t,n,i,o=document.createElement("a");return o.href=e,t=o.protocol,i=o.port,n=o.hostname,t.toLowerCase()!==window.location.protocol.toLowerCase()||(n.toLowerCase()!==window.location.hostname.toLowerCase()||i!==window.location.port&&!qq.ie())}function s(t,n){t.onload=function(){t.onload=null,t.onerror=null,n.success(t)},t.onerror=function(){t.onload=null,t.onerror=null,e("Problem drawing thumbnail!","error"),n.failure(t,"Problem drawing thumbnail!")}}function l(e,t){e.qqImageRendered=function(){t.success(e)}}function u(i,o){var r=t(i)||n(i);return t(i)?s(i,o):n(i)?l(i,o):(o.failure(i),e(qq.format("Element container of type {} is not supported!",i.tagName),"error")),r}function c(t,n,i){var o=new qq.Promise,r=new qq.Identify(t,e),a=i.maxSize,s=null==i.orient||i.orient,l=function(){n.onerror=null,n.onload=null,e("Could not render preview, file may be too large!","error"),o.failure(n,"Browser cannot render image!")};return r.isPreviewable().then(function(r){var c={parse:function(){return(new qq.Promise).success()}},d=s?new qq.Exif(t,e):c,p=new qq.MegaPixImage(t,l);u(n,o)&&d.parse().then(function(e){var t=e&&e.Orientation;p.render(n,{maxWidth:a,maxHeight:a,orientation:t,mime:r,resize:i.customResizeFunction})},function(t){e(qq.format("EXIF data could not be parsed ({}).  Assuming orientation = 1.",t)),p.render(n,{maxWidth:a,maxHeight:a,mime:r,resize:i.customResizeFunction})})},function(){e("Not previewable"),o.failure(n,"Not previewable")}),o}function d(e,t,n,i,o){var s=new Image,l=new qq.Promise;u(s,l),a(e)&&(s.crossOrigin="anonymous"),s.src=e,l.then(function(){u(t,n);var a=new qq.MegaPixImage(s);a.render(t,{maxWidth:i,maxHeight:i,mime:r(e),resize:o})},n.failure)}function p(e,t,n,i){u(t,n),qq(t).css({maxWidth:i+"px",maxHeight:i+"px"}),t.src=e}function h(e,r,s){var l=new qq.Promise,c=s.scale,h=c?s.maxSize:null;return c&&t(r)?o()?a(e)&&!i()?p(e,r,l,h):d(e,r,l,h):p(e,r,l,h):n(r)?d(e,r,l,h):u(r,l)&&(r.src=e),l}qq.extend(this,{generate:function(t,n,i){return qq.isString(t)?(e("Attempting to update thumbnail based on server response."),h(t,n,i||{})):(e("Attempting to draw client-side image preview."),c(t,n,i||{}))}})},qq.Exif=function(e,t){"use strict";function n(e){for(var t=0,n=0;e.length>0;)t+=parseInt(e.substring(0,2),16)*Math.pow(2,n),e=e.substring(2,e.length),n+=8;return t}function i(t,n){var o=t,r=n;return void 0===o&&(o=2,r=new qq.Promise),qq.readBlobToHex(e,o,4).then(function(e){var t,n=/^ffe([0-9])/.exec(e);n?"1"!==n[1]?(t=parseInt(e.slice(4,8),16),i(o+t+2,r)):r.success(o):r.failure("No EXIF header to be found!")}),r}function o(){var t=new qq.Promise;return qq.readBlobToHex(e,0,6).then(function(e){0!==e.indexOf("ffd8")?t.failure("Not a valid JPEG!"):i().then(function(e){t.success(e)},function(e){t.failure(e)})}),t}function r(t){var n=new qq.Promise;return qq.readBlobToHex(e,t+10,2).then(function(e){n.success("4949"===e)}),n}function a(t,i){var o=new qq.Promise;return qq.readBlobToHex(e,t+18,2).then(function(e){return i?o.success(n(e)):void o.success(parseInt(e,16))}),o}function s(t,n){var i=t+20,o=12*n;return qq.readBlobToHex(e,i,o)}function l(e){for(var t=[],n=0;n+24<=e.length;)t.push(e.slice(n,n+24)),n+=24;return t}function u(e,t){var i=16,o=qq.extend([],c),r={};return qq.each(t,function(t,a){var s,l,u,c=a.slice(0,4),p=e?n(c):parseInt(c,16),h=o.indexOf(p);if(h>=0&&(l=d[p].name,u=d[p].bytes,s=a.slice(i,i+2*u),r[l]=e?n(s):parseInt(s,16),o.splice(h,1)),0===o.length)return!1}),r}var c=[274],d={274:{name:"Orientation",bytes:2}};qq.extend(this,{parse:function(){var n=new qq.Promise,i=function(e){t(qq.format("EXIF header parse failed: '{}' ",e)),n.failure(e)};return o().then(function(o){t(qq.format("Moving forward with EXIF header parsing for '{}'",void 0===e.name?"blob":e.name)),r(o).then(function(e){t(qq.format("EXIF Byte order is {} endian",e?"little":"big")),a(o,e).then(function(r){t(qq.format("Found {} APP1 directory entries",r)),s(o,r).then(function(i){var o=l(i),r=u(e,o);t("Successfully parsed some EXIF tags"),n.success(r)},i)},i)},i)},i),n}})},qq.Identify=function(e,t){"use strict";function n(e,t){var n=!1,i=[].concat(e);return qq.each(i,function(e,i){if(0===t.indexOf(i))return n=!0,!1}),n}qq.extend(this,{isPreviewable:function(){var i=this,o=new qq.Promise,r=!1,a=void 0===e.name?"blob":e.name;return t(qq.format("Attempting to determine if {} can be rendered in this browser",a)),t("First pass: check type attribute of blob object."),this.isPreviewableSync()?(t("Second pass: check for magic bytes in file header."),qq.readBlobToHex(e,0,4).then(function(e){qq.each(i.PREVIEWABLE_MIME_TYPES,function(t,i){if(n(i,e))return("image/tiff"!==t||qq.supportedFeatures.tiffPreviews)&&(r=!0,o.success(t)),!1}),t(qq.format("'{}' is {} able to be rendered in this browser",a,r?"":"NOT")),r||o.failure()},function(){t("Error reading file w/ name '"+a+"'.  Not able to be rendered in this browser."),o.failure()})):o.failure(),o},isPreviewableSync:function(){var n=e.type,i=qq.indexOf(Object.keys(this.PREVIEWABLE_MIME_TYPES),n)>=0,o=!1,r=void 0===e.name?"blob":e.name;return i&&(o="image/tiff"!==n||qq.supportedFeatures.tiffPreviews),!o&&t(r+" is not previewable in this browser per the blob's type attr"),o}})},qq.Identify.prototype.PREVIEWABLE_MIME_TYPES={"image/jpeg":"ffd8ff","image/gif":"474946","image/png":"89504e","image/bmp":"424d","image/tiff":["49492a00","4d4d002a"]},qq.ImageValidation=function(e,t){"use strict";function n(e){var t=!1;return qq.each(e,function(e,n){if(n>0)return t=!0,!1}),t}function i(){var n=new qq.Promise;return new qq.Identify(e,t).isPreviewable().then(function(){var i=new Image,o=window.URL&&window.URL.createObjectURL?window.URL:window.webkitURL&&window.webkitURL.createObjectURL?window.webkitURL:null;o?(i.onerror=function(){t("Cannot determine dimensions for image.  May be too large.","error"),n.failure()},i.onload=function(){n.success({width:this.width,height:this.height})},i.src=o.createObjectURL(e)):(t("No createObjectURL function available to generate image URL!","error"),n.failure())},n.failure),n}function o(e,t){var n;return qq.each(e,function(e,i){if(i>0){var o=/(max|min)(Width|Height)/.exec(e),r=o[2].charAt(0).toLowerCase()+o[2].slice(1),a=t[r];switch(o[1]){case"min":if(a<i)return n=e,!1;break;case"max":if(a>i)return n=e,!1}}}),n}this.validate=function(e){var r=new qq.Promise;return t("Attempting to validate image."),n(e)?i().then(function(t){var n=o(e,t);n?r.failure(n):r.success()},r.success):r.success(),r}},qq.Session=function(e){"use strict";function t(e){return!!qq.isArray(e)||void i.log("Session response is not an array.","error")}function n(e,n,o,r){var a=!1;n=n&&t(e),n&&qq.each(e,function(e,t){if(null==t.uuid)a=!0,i.log(qq.format("Session response item {} did not include a valid UUID - ignoring.",e),"error");else if(null==t.name)a=!0,i.log(qq.format("Session response item {} did not include a valid name - ignoring.",e),"error");else try{return i.addFileRecord(t),!0}catch(n){a=!0,i.log(n.message,"error")}return!1}),r[n&&!a?"success":"failure"](e,o)}var i={endpoint:null,params:{},customHeaders:{},cors:{},addFileRecord:function(e){},log:function(e,t){}};qq.extend(i,e,!0),this.refresh=function(){var e=new qq.Promise,t=function(t,i,o){n(t,i,o,e)},o=qq.extend({},i),r=new qq.SessionAjaxRequester(qq.extend(o,{onComplete:t}));return r.queryServer(),e}},qq.SessionAjaxRequester=function(e){"use strict";function t(e,t,n){var o=null;if(null!=t.responseText)try{o=qq.parseJson(t.responseText)}catch(r){i.log("Problem parsing session response: "+r.message,"error"),n=!0}i.onComplete(o,!n,t)}var n,i={endpoint:null,customHeaders:{},params:{},cors:{expected:!1,sendCredentials:!1},onComplete:function(e,t,n){},log:function(e,t){}};qq.extend(i,e),n=qq.extend(this,new qq.AjaxRequester({acceptHeader:"application/json",validMethods:["GET"],method:"GET",endpointStore:{get:function(){return i.endpoint}},customHeaders:i.customHeaders,log:i.log,onComplete:t,cors:i.cors})),qq.extend(this,{queryServer:function(){var e=qq.extend({},i.params);i.log("Session query request."),n.initTransport("sessionRefresh").withParams(e).withCacheBuster().send()}})},qq.FormSupport=function(e,t,n){"use strict";function i(e){e.getAttribute("action")&&(s.newEndpoint=e.getAttribute("action"))}function o(e,t){return!(e.checkValidity&&!e.checkValidity())||(n("Form did not pass validation checks - will not upload.","error"),void t())}function r(e){var n=e.submit;qq(e).attach("submit",function(i){i=i||window.event,i.preventDefault?i.preventDefault():i.returnValue=!1,o(e,n)&&t()}),e.submit=function(){o(e,n)&&t()}}function a(e){return e&&(qq.isString(e)&&(e=document.getElementById(e)),e&&(n("Attaching to form element."),i(e),l&&r(e))),e}var s=this,l=e.interceptSubmit,u=e.element,c=e.autoUpload;qq.extend(this,{newEndpoint:null,newAutoUpload:c,attachedToForm:!1,getFormInputsAsObject:function(){return null==u?null:s._form2Obj(u)}}),u=a(u),this.attachedToForm=!!u},qq.extend(qq.FormSupport.prototype,{_form2Obj:function(e){"use strict";var t={},n=function(e){var t=["button","image","reset","submit"];return qq.indexOf(t,e.toLowerCase())<0},i=function(e){return qq.indexOf(["checkbox","radio"],e.toLowerCase())>=0},o=function(e){return!(!i(e.type)||e.checked)||e.disabled&&"hidden"!==e.type.toLowerCase()},r=function(e){var t=null;return qq.each(qq(e).children(),function(e,n){if("option"===n.tagName.toLowerCase()&&n.selected)return t=n.value,
!1}),t};return qq.each(e.elements,function(e,i){if(!qq.isInput(i,!0)&&"textarea"!==i.tagName.toLowerCase()||!n(i.type)||o(i)){if("select"===i.tagName.toLowerCase()&&!o(i)){var a=r(i);null!==a&&(t[i.name]=a)}}else t[i.name]=i.value}),t}}),qq.Scaler=function(e,t){"use strict";var n=e.customResizer,i=e.sendOriginal,o=e.orient,r=e.defaultType,a=e.defaultQuality/100,s=e.failureText,l=e.includeExif,u=this._getSortedSizes(e.sizes);qq.extend(this,{enabled:qq.supportedFeatures.scaling&&u.length>0,getFileRecords:function(e,c,d){var p=this,h=[],q=d.blob?d.blob:d,f=new qq.Identify(q,t);return f.isPreviewableSync()?(qq.each(u,function(e,i){var u=p._determineOutputType({defaultType:r,requestedType:i.type,refType:q.type});h.push({uuid:qq.getUniqueId(),name:p._getName(c,{name:i.name,type:u,refType:q.type}),blob:new qq.BlobProxy(q,qq.bind(p._generateScaledImage,p,{customResizeFunction:n,maxSize:i.maxSize,orient:o,type:u,quality:a,failedText:s,includeExif:l,log:t}))})}),h.push({uuid:e,name:c,size:q.size,blob:i?q:null})):h.push({uuid:e,name:c,size:q.size,blob:q}),h},handleNewFile:function(e,t,n,i,o,r,a,s){var l=this,u=(e.qqButtonId||e.blob&&e.blob.qqButtonId,[]),c=null,d=s.addFileToHandler,p=s.uploadData,h=s.paramsStore,q=qq.getUniqueId();qq.each(l.getFileRecords(n,t,e),function(e,t){var n,i=t.size;t.blob instanceof qq.BlobProxy&&(i=-1),n=p.addFile({uuid:t.uuid,name:t.name,size:i,batchId:r,proxyGroupId:q}),t.blob instanceof qq.BlobProxy?u.push(n):c=n,t.blob?(d(n,t.blob),o.push({id:n,file:t.blob})):p.setStatus(n,qq.status.REJECTED)}),null!==c&&(qq.each(u,function(e,t){var n={qqparentuuid:p.retrieve({id:c}).uuid,qqparentsize:p.retrieve({id:c}).size};n[a]=p.retrieve({id:t}).uuid,p.setParentId(t,c),h.addReadOnly(t,n)}),u.length&&!function(){var e={};e[a]=p.retrieve({id:c}).uuid,h.addReadOnly(c,e)}())}})},qq.extend(qq.Scaler.prototype,{scaleImage:function(e,t,n){"use strict";if(!qq.supportedFeatures.scaling)throw new qq.Error("Scaling is not supported in this browser!");var i=new qq.Promise,o=n.log,r=n.getFile(e),a=n.uploadData.retrieve({id:e}),s=a&&a.name,l=a&&a.uuid,u={customResizer:t.customResizer,sendOriginal:!1,orient:t.orient,defaultType:t.type||null,defaultQuality:t.quality,failedToScaleText:"Unable to scale",sizes:[{name:"",maxSize:t.maxSize}]},c=new qq.Scaler(u,o);return qq.Scaler&&qq.supportedFeatures.imagePreviews&&r?qq.bind(function(){var t=c.getFileRecords(l,s,r)[0];t&&t.blob instanceof qq.BlobProxy?t.blob.create().then(i.success,i.failure):(o(e+" is not a scalable image!","error"),i.failure())},this)():(i.failure(),o("Could not generate requested scaled image for "+e+".  Scaling is either not possible in this browser, or the file could not be located.","error")),i},_determineOutputType:function(e){"use strict";var t=e.requestedType,n=e.defaultType,i=e.refType;return n||t?t&&qq.indexOf(Object.keys(qq.Identify.prototype.PREVIEWABLE_MIME_TYPES),t)>=0?"image/tiff"===t?qq.supportedFeatures.tiffPreviews?t:n:t:n:"image/jpeg"!==i?"image/png":i},_getName:function(e,t){"use strict";var n=e.lastIndexOf("."),i=t.type||"image/png",o=t.refType,r="",a=qq.getExtension(e),s="";return t.name&&t.name.trim().length&&(s=" ("+t.name+")"),n>=0?(r=e.substr(0,n),o!==i&&(a=i.split("/")[1]),r+=s+"."+a):r=e+s,r},_getSortedSizes:function(e){"use strict";return e=qq.extend([],e),e.sort(function(e,t){return e.maxSize>t.maxSize?1:e.maxSize<t.maxSize?-1:0})},_generateScaledImage:function(e,t){"use strict";var n=this,i=e.customResizeFunction,o=e.log,r=e.maxSize,a=e.orient,s=e.type,l=e.quality,u=e.failedText,c=e.includeExif&&"image/jpeg"===t.type&&"image/jpeg"===s,d=new qq.Promise,p=new qq.ImageGenerator(o),h=document.createElement("canvas");return o("Attempting to generate scaled version for "+t.name),p.generate(t,h,{maxSize:r,orient:a,customResizeFunction:i}).then(function(){var e=h.toDataURL(s,l),i=function(){o("Success generating scaled version for "+t.name);var n=qq.dataUriToBlob(e);d.success(n)};c?n._insertExifHeader(t,e,o).then(function(t){e=t,i()},function(){o("Problem inserting EXIF header into scaled image.  Using scaled image w/out EXIF data.","error"),i()}):i()},function(){o("Failed attempt to generate scaled version for "+t.name,"error"),d.failure(u)}),d},_insertExifHeader:function(e,t,n){"use strict";var i=new FileReader,o=new qq.Promise,r="";return i.onload=function(){r=i.result,o.success(qq.ExifRestorer.restore(r,t))},i.onerror=function(){n("Problem reading "+e.name+" during attempt to transfer EXIF data to scaled version.","error"),o.failure()},i.readAsDataURL(e),o},_dataUriToBlob:function(e){"use strict";var t,n,i,o;return t=e.split(",")[0].indexOf("base64")>=0?atob(e.split(",")[1]):decodeURI(e.split(",")[1]),n=e.split(",")[0].split(":")[1].split(";")[0],i=new ArrayBuffer(t.length),o=new Uint8Array(i),qq.each(t,function(e,t){o[e]=t.charCodeAt(0)}),this._createBlob(i,n)},_createBlob:function(e,t){"use strict";var n=window.BlobBuilder||window.WebKitBlobBuilder||window.MozBlobBuilder||window.MSBlobBuilder,i=n&&new n;return i?(i.append(e),i.getBlob(t)):new Blob([e],{type:t})}}),qq.ExifRestorer=function(){var e={};return e.KEY_STR="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",e.encode64=function(e){var t,n,i,o,r,a="",s="",l="",u=0;do t=e[u++],n=e[u++],s=e[u++],i=t>>2,o=(3&t)<<4|n>>4,r=(15&n)<<2|s>>6,l=63&s,isNaN(n)?r=l=64:isNaN(s)&&(l=64),a=a+this.KEY_STR.charAt(i)+this.KEY_STR.charAt(o)+this.KEY_STR.charAt(r)+this.KEY_STR.charAt(l),t=n=s="",i=o=r=l="";while(u<e.length);return a},e.restore=function(e,t){var n="data:image/jpeg;base64,";if(!e.match(n))return t;var i=this.decode64(e.replace(n,"")),o=this.slice2Segments(i),r=this.exifManipulation(t,o);return n+this.encode64(r)},e.exifManipulation=function(e,t){var n=this.getExifArray(t),i=this.insertExif(e,n),o=new Uint8Array(i);return o},e.getExifArray=function(e){for(var t,n=0;n<e.length;n++)if(t=e[n],255==t[0]&225==t[1])return t;return[]},e.insertExif=function(e,t){var n=e.replace("data:image/jpeg;base64,",""),i=this.decode64(n),o=i.indexOf(255,3),r=i.slice(0,o),a=i.slice(o),s=r;return s=s.concat(t),s=s.concat(a)},e.slice2Segments=function(e){for(var t=0,n=[];;){if(255==e[t]&218==e[t+1])break;if(255==e[t]&216==e[t+1])t+=2;else{var i=256*e[t+2]+e[t+3],o=t+i+2,r=e.slice(t,o);n.push(r),t=o}if(t>e.length)break}return n},e.decode64=function(e){var t,n,i,o,r,a="",s="",l=0,u=[],c=/[^A-Za-z0-9\+\/\=]/g;if(c.exec(e))throw new Error("There were invalid base64 characters in the input text.  Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='");e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");do i=this.KEY_STR.indexOf(e.charAt(l++)),o=this.KEY_STR.indexOf(e.charAt(l++)),r=this.KEY_STR.indexOf(e.charAt(l++)),s=this.KEY_STR.indexOf(e.charAt(l++)),t=i<<2|o>>4,n=(15&o)<<4|r>>2,a=(3&r)<<6|s,u.push(t),64!=r&&u.push(n),64!=s&&u.push(a),t=n=a="",i=o=r=s="";while(l<e.length);return u},e}(),qq.TotalProgress=function(e,t){"use strict";var n={},i=0,o=0,r=-1,a=-1,s=function(t,n){t===r&&n===a||e(t,n),r=t,a=n},l=function(e,t){var n=!0;return qq.each(e,function(e,i){if(qq.indexOf(t,i)>=0)return n=!1,!1}),n},u=function(e){p(e,-1,-1),delete n[e]},c=function(e,t,n){(0===t.length||l(t,n))&&(s(o,o),this.reset())},d=function(e){var i=t(e);i>0&&(p(e,0,i),n[e]={loaded:0,total:i})},p=function(e,t,r){var a=n[e]?n[e].loaded:0,l=n[e]?n[e].total:0;t===-1&&r===-1?(i-=a,o-=l):(t&&(i+=t-a),r&&(o+=r-l)),s(i,o)};qq.extend(this,{onAllComplete:c,onStatusChange:function(e,t,n){n===qq.status.CANCELED||n===qq.status.REJECTED?u(e):n===qq.status.SUBMITTING&&d(e)},onIndividualProgress:function(e,t,i){p(e,t,i),n[e]={loaded:t,total:i}},onNewSize:function(e){d(e)},reset:function(){n={},i=0,o=0}})},qq.UiEventHandler=function(e,t){"use strict";function n(e){i.attach(e,o.eventType,function(e){e=e||window.event;var t=e.target||e.srcElement;o.onHandled(t,e)})}var i=new qq.DisposeSupport,o={eventType:"click",attachTo:null,onHandled:function(e,t){}};qq.extend(this,{addHandler:function(e){n(e)},dispose:function(){i.dispose()}}),qq.extend(t,{getFileIdFromItem:function(e){return e.qqFileId},getDisposeSupport:function(){return i}}),qq.extend(o,e),o.attachTo&&n(o.attachTo)},qq.FileButtonsClickHandler=function(e){"use strict";function t(e,t){qq.each(o,function(n,o){var r,a=n.charAt(0).toUpperCase()+n.slice(1);if(i.templating["is"+a](e))return r=i.templating.getFileId(e),qq.preventDefault(t),i.log(qq.format("Detected valid file button click event on file '{}', ID: {}.",i.onGetName(r),r)),o(r),!1})}var n={},i={templating:null,log:function(e,t){},onDeleteFile:function(e){},onCancel:function(e){},onRetry:function(e){},onPause:function(e){},onContinue:function(e){},onGetName:function(e){}},o={cancel:function(e){i.onCancel(e)},retry:function(e){i.onRetry(e)},deleteButton:function(e){i.onDeleteFile(e)},pause:function(e){i.onPause(e)},continueButton:function(e){i.onContinue(e)}};qq.extend(i,e),i.eventType="click",i.onHandled=t,i.attachTo=i.templating.getFileList(),qq.extend(this,new qq.UiEventHandler(i,n))},qq.FilenameClickHandler=function(e){"use strict";function t(e,t){if(i.templating.isFileName(e)||i.templating.isEditIcon(e)){var o=i.templating.getFileId(e),r=i.onGetUploadStatus(o);r===qq.status.SUBMITTED&&(i.log(qq.format("Detected valid filename click event on file '{}', ID: {}.",i.onGetName(o),o)),qq.preventDefault(t),n.handleFilenameEdit(o,e,!0))}}var n={},i={templating:null,log:function(e,t){},classes:{file:"qq-upload-file",editNameIcon:"qq-edit-filename-icon"},onGetUploadStatus:function(e){},onGetName:function(e){}};qq.extend(i,e),i.eventType="click",i.onHandled=t,qq.extend(this,new qq.FilenameEditHandler(i,n))},qq.FilenameInputFocusInHandler=function(e,t){"use strict";function n(e,n){if(i.templating.isEditInput(e)){var o=i.templating.getFileId(e),r=i.onGetUploadStatus(o);r===qq.status.SUBMITTED&&(i.log(qq.format("Detected valid filename input focus event on file '{}', ID: {}.",i.onGetName(o),o)),t.handleFilenameEdit(o,e))}}var i={templating:null,onGetUploadStatus:function(e){},log:function(e,t){}};t||(t={}),i.eventType="focusin",i.onHandled=n,qq.extend(i,e),qq.extend(this,new qq.FilenameEditHandler(i,t))},qq.FilenameInputFocusHandler=function(e){"use strict";e.eventType="focus",e.attachTo=null,qq.extend(this,new qq.FilenameInputFocusInHandler(e,{}))},qq.FilenameEditHandler=function(e,t){"use strict";function n(e){var t=s.onGetName(e),n=t.lastIndexOf(".");return n>0&&(t=t.substr(0,n)),t}function i(e){var t=s.onGetName(e);return qq.getExtension(t)}function o(e,t){var n,o=e.value;void 0!==o&&qq.trimStr(o).length>0&&(n=i(t),void 0!==n&&(o=o+"."+n),s.onSetName(t,o)),s.onEditingStatusChange(t,!1)}function r(e,n){t.getDisposeSupport().attach(e,"blur",function(){o(e,n)})}function a(e,n){t.getDisposeSupport().attach(e,"keyup",function(t){var i=t.keyCode||t.which;13===i&&o(e,n)})}var s={templating:null,log:function(e,t){},onGetUploadStatus:function(e){},onGetName:function(e){},onSetName:function(e,t){},onEditingStatusChange:function(e,t){}};qq.extend(s,e),s.attachTo=s.templating.getFileList(),qq.extend(this,new qq.UiEventHandler(s,t)),qq.extend(t,{handleFilenameEdit:function(e,t,i){var o=s.templating.getEditInput(e);s.onEditingStatusChange(e,!0),o.value=n(e),i&&o.focus(),r(o,e),a(o,e)}})},"function"==typeof define&&define.amd?define(function(){return qq}):"undefined"!=typeof module&&module.exports?module.exports=qq:global.qq=qq}(window);
=======
/*!
* Fine Uploader
*
* Copyright 2013-present, Widen Enterprises, Inc.
*
* Version: 5.10.0
*
* Homepage: http://fineuploader.com
*
* Repository: git://github.com/FineUploader/fine-uploader.git
*
* Licensed only under the MIT license (http://fineuploader.com/licensing).
*/ 


(function(global) {
/*globals window, navigator, document, FormData, File, HTMLInputElement, XMLHttpRequest, Blob, Storage, ActiveXObject */
/* jshint -W079 */
var qq = function(element) {
    "use strict";

    return {
        hide: function() {
            element.style.display = "none";
            return this;
        },

        /** Returns the function which detaches attached event */
        attach: function(type, fn) {
            if (element.addEventListener) {
                element.addEventListener(type, fn, false);
            } else if (element.attachEvent) {
                element.attachEvent("on" + type, fn);
            }
            return function() {
                qq(element).detach(type, fn);
            };
        },

        detach: function(type, fn) {
            if (element.removeEventListener) {
                element.removeEventListener(type, fn, false);
            } else if (element.attachEvent) {
                element.detachEvent("on" + type, fn);
            }
            return this;
        },

        contains: function(descendant) {
            // The [W3C spec](http://www.w3.org/TR/domcore/#dom-node-contains)
            // says a `null` (or ostensibly `undefined`) parameter
            // passed into `Node.contains` should result in a false return value.
            // IE7 throws an exception if the parameter is `undefined` though.
            if (!descendant) {
                return false;
            }

            // compareposition returns false in this case
            if (element === descendant) {
                return true;
            }

            if (element.contains) {
                return element.contains(descendant);
            } else {
                /*jslint bitwise: true*/
                return !!(descendant.compareDocumentPosition(element) & 8);
            }
        },

        /**
         * Insert this element before elementB.
         */
        insertBefore: function(elementB) {
            elementB.parentNode.insertBefore(element, elementB);
            return this;
        },

        remove: function() {
            element.parentNode.removeChild(element);
            return this;
        },

        /**
         * Sets styles for an element.
         * Fixes opacity in IE6-8.
         */
        css: function(styles) {
            /*jshint eqnull: true*/
            if (element.style == null) {
                throw new qq.Error("Can't apply style to node as it is not on the HTMLElement prototype chain!");
            }

            /*jshint -W116*/
            if (styles.opacity != null) {
                if (typeof element.style.opacity !== "string" && typeof (element.filters) !== "undefined") {
                    styles.filter = "alpha(opacity=" + Math.round(100 * styles.opacity) + ")";
                }
            }
            qq.extend(element.style, styles);

            return this;
        },

        hasClass: function(name, considerParent) {
            var re = new RegExp("(^| )" + name + "( |$)");
            return re.test(element.className) || !!(considerParent && re.test(element.parentNode.className));
        },

        addClass: function(name) {
            if (!qq(element).hasClass(name)) {
                element.className += " " + name;
            }
            return this;
        },

        removeClass: function(name) {
            var re = new RegExp("(^| )" + name + "( |$)");
            element.className = element.className.replace(re, " ").replace(/^\s+|\s+$/g, "");
            return this;
        },

        getByClass: function(className, first) {
            var candidates,
                result = [];

            if (first && element.querySelector) {
                return element.querySelector("." + className);
            }
            else if (element.querySelectorAll) {
                return element.querySelectorAll("." + className);
            }

            candidates = element.getElementsByTagName("*");

            qq.each(candidates, function(idx, val) {
                if (qq(val).hasClass(className)) {
                    result.push(val);
                }
            });
            return first ? result[0] : result;
        },

        getFirstByClass: function(className) {
            return qq(element).getByClass(className, true);
        },

        children: function() {
            var children = [],
                child = element.firstChild;

            while (child) {
                if (child.nodeType === 1) {
                    children.push(child);
                }
                child = child.nextSibling;
            }

            return children;
        },

        setText: function(text) {
            element.innerText = text;
            element.textContent = text;
            return this;
        },

        clearText: function() {
            return qq(element).setText("");
        },

        // Returns true if the attribute exists on the element
        // AND the value of the attribute is NOT "false" (case-insensitive)
        hasAttribute: function(attrName) {
            var attrVal;

            if (element.hasAttribute) {

                if (!element.hasAttribute(attrName)) {
                    return false;
                }

                /*jshint -W116*/
                return (/^false$/i).exec(element.getAttribute(attrName)) == null;
            }
            else {
                attrVal = element[attrName];

                if (attrVal === undefined) {
                    return false;
                }

                /*jshint -W116*/
                return (/^false$/i).exec(attrVal) == null;
            }
        }
    };
};

(function() {
    "use strict";

    qq.canvasToBlob = function(canvas, mime, quality) {
        return qq.dataUriToBlob(canvas.toDataURL(mime, quality));
    };

    qq.dataUriToBlob = function(dataUri) {
        var arrayBuffer, byteString,
            createBlob = function(data, mime) {
                var BlobBuilder = window.BlobBuilder ||
                        window.WebKitBlobBuilder ||
                        window.MozBlobBuilder ||
                        window.MSBlobBuilder,
                    blobBuilder = BlobBuilder && new BlobBuilder();

                if (blobBuilder) {
                    blobBuilder.append(data);
                    return blobBuilder.getBlob(mime);
                }
                else {
                    return new Blob([data], {type: mime});
                }
            },
            intArray, mimeString;

        // convert base64 to raw binary data held in a string
        if (dataUri.split(",")[0].indexOf("base64") >= 0) {
            byteString = atob(dataUri.split(",")[1]);
        }
        else {
            byteString = decodeURI(dataUri.split(",")[1]);
        }

        // extract the MIME
        mimeString = dataUri.split(",")[0]
            .split(":")[1]
            .split(";")[0];

        // write the bytes of the binary string to an ArrayBuffer
        arrayBuffer = new ArrayBuffer(byteString.length);
        intArray = new Uint8Array(arrayBuffer);
        qq.each(byteString, function(idx, character) {
            intArray[idx] = character.charCodeAt(0);
        });

        return createBlob(arrayBuffer, mimeString);
    };

    qq.log = function(message, level) {
        if (window.console) {
            if (!level || level === "info") {
                window.console.log(message);
            }
            else
            {
                if (window.console[level]) {
                    window.console[level](message);
                }
                else {
                    window.console.log("<" + level + "> " + message);
                }
            }
        }
    };

    qq.isObject = function(variable) {
        return variable && !variable.nodeType && Object.prototype.toString.call(variable) === "[object Object]";
    };

    qq.isFunction = function(variable) {
        return typeof (variable) === "function";
    };

    /**
     * Check the type of a value.  Is it an "array"?
     *
     * @param value value to test.
     * @returns true if the value is an array or associated with an `ArrayBuffer`
     */
    qq.isArray = function(value) {
        return Object.prototype.toString.call(value) === "[object Array]" ||
            (value && window.ArrayBuffer && value.buffer && value.buffer.constructor === ArrayBuffer);
    };

    // Looks for an object on a `DataTransfer` object that is associated with drop events when utilizing the Filesystem API.
    qq.isItemList = function(maybeItemList) {
        return Object.prototype.toString.call(maybeItemList) === "[object DataTransferItemList]";
    };

    // Looks for an object on a `NodeList` or an `HTMLCollection`|`HTMLFormElement`|`HTMLSelectElement`
    // object that is associated with collections of Nodes.
    qq.isNodeList = function(maybeNodeList) {
        return Object.prototype.toString.call(maybeNodeList) === "[object NodeList]" ||
            // If `HTMLCollection` is the actual type of the object, we must determine this
            // by checking for expected properties/methods on the object
            (maybeNodeList.item && maybeNodeList.namedItem);
    };

    qq.isString = function(maybeString) {
        return Object.prototype.toString.call(maybeString) === "[object String]";
    };

    qq.trimStr = function(string) {
        if (String.prototype.trim) {
            return string.trim();
        }

        return string.replace(/^\s+|\s+$/g, "");
    };

    /**
     * @param str String to format.
     * @returns {string} A string, swapping argument values with the associated occurrence of {} in the passed string.
     */
    qq.format = function(str) {

        var args =  Array.prototype.slice.call(arguments, 1),
            newStr = str,
            nextIdxToReplace = newStr.indexOf("{}");

        qq.each(args, function(idx, val) {
            var strBefore = newStr.substring(0, nextIdxToReplace),
                strAfter = newStr.substring(nextIdxToReplace + 2);

            newStr = strBefore + val + strAfter;
            nextIdxToReplace = newStr.indexOf("{}", nextIdxToReplace + val.length);

            // End the loop if we have run out of tokens (when the arguments exceed the # of tokens)
            if (nextIdxToReplace < 0) {
                return false;
            }
        });

        return newStr;
    };

    qq.isFile = function(maybeFile) {
        return window.File && Object.prototype.toString.call(maybeFile) === "[object File]";
    };

    qq.isFileList = function(maybeFileList) {
        return window.FileList && Object.prototype.toString.call(maybeFileList) === "[object FileList]";
    };

    qq.isFileOrInput = function(maybeFileOrInput) {
        return qq.isFile(maybeFileOrInput) || qq.isInput(maybeFileOrInput);
    };

    qq.isInput = function(maybeInput, notFile) {
        var evaluateType = function(type) {
            var normalizedType = type.toLowerCase();

            if (notFile) {
                return normalizedType !== "file";
            }

            return normalizedType === "file";
        };

        if (window.HTMLInputElement) {
            if (Object.prototype.toString.call(maybeInput) === "[object HTMLInputElement]") {
                if (maybeInput.type && evaluateType(maybeInput.type)) {
                    return true;
                }
            }
        }
        if (maybeInput.tagName) {
            if (maybeInput.tagName.toLowerCase() === "input") {
                if (maybeInput.type && evaluateType(maybeInput.type)) {
                    return true;
                }
            }
        }

        return false;
    };

    qq.isBlob = function(maybeBlob) {
        if (window.Blob && Object.prototype.toString.call(maybeBlob) === "[object Blob]") {
            return true;
        }
    };

    qq.isXhrUploadSupported = function() {
        var input = document.createElement("input");
        input.type = "file";

        return (
            input.multiple !== undefined &&
                typeof File !== "undefined" &&
                typeof FormData !== "undefined" &&
                typeof (qq.createXhrInstance()).upload !== "undefined");
    };

    // Fall back to ActiveX is native XHR is disabled (possible in any version of IE).
    qq.createXhrInstance = function() {
        if (window.XMLHttpRequest) {
            return new XMLHttpRequest();
        }

        try {
            return new ActiveXObject("MSXML2.XMLHTTP.3.0");
        }
        catch (error) {
            qq.log("Neither XHR or ActiveX are supported!", "error");
            return null;
        }
    };

    qq.isFolderDropSupported = function(dataTransfer) {
        return dataTransfer.items &&
            dataTransfer.items.length > 0 &&
            dataTransfer.items[0].webkitGetAsEntry;
    };

    qq.isFileChunkingSupported = function() {
        return !qq.androidStock() && //Android's stock browser cannot upload Blobs correctly
            qq.isXhrUploadSupported() &&
            (File.prototype.slice !== undefined || File.prototype.webkitSlice !== undefined || File.prototype.mozSlice !== undefined);
    };

    qq.sliceBlob = function(fileOrBlob, start, end) {
        var slicer = fileOrBlob.slice || fileOrBlob.mozSlice || fileOrBlob.webkitSlice;

        return slicer.call(fileOrBlob, start, end);
    };

    qq.arrayBufferToHex = function(buffer) {
        var bytesAsHex = "",
            bytes = new Uint8Array(buffer);

        qq.each(bytes, function(idx, byt) {
            var byteAsHexStr = byt.toString(16);

            if (byteAsHexStr.length < 2) {
                byteAsHexStr = "0" + byteAsHexStr;
            }

            bytesAsHex += byteAsHexStr;
        });

        return bytesAsHex;
    };

    qq.readBlobToHex = function(blob, startOffset, length) {
        var initialBlob = qq.sliceBlob(blob, startOffset, startOffset + length),
            fileReader = new FileReader(),
            promise = new qq.Promise();

        fileReader.onload = function() {
            promise.success(qq.arrayBufferToHex(fileReader.result));
        };

        fileReader.onerror = promise.failure;

        fileReader.readAsArrayBuffer(initialBlob);

        return promise;
    };

    qq.extend = function(first, second, extendNested) {
        qq.each(second, function(prop, val) {
            if (extendNested && qq.isObject(val)) {
                if (first[prop] === undefined) {
                    first[prop] = {};
                }
                qq.extend(first[prop], val, true);
            }
            else {
                first[prop] = val;
            }
        });

        return first;
    };

    /**
     * Allow properties in one object to override properties in another,
     * keeping track of the original values from the target object.
     *
     * Note that the pre-overriden properties to be overriden by the source will be passed into the `sourceFn` when it is invoked.
     *
     * @param target Update properties in this object from some source
     * @param sourceFn A function that, when invoked, will return properties that will replace properties with the same name in the target.
     * @returns {object} The target object
     */
    qq.override = function(target, sourceFn) {
        var super_ = {},
            source = sourceFn(super_);

        qq.each(source, function(srcPropName, srcPropVal) {
            if (target[srcPropName] !== undefined) {
                super_[srcPropName] = target[srcPropName];
            }

            target[srcPropName] = srcPropVal;
        });

        return target;
    };

    /**
     * Searches for a given element (elt) in the array, returns -1 if it is not present.
     */
    qq.indexOf = function(arr, elt, from) {
        if (arr.indexOf) {
            return arr.indexOf(elt, from);
        }

        from = from || 0;
        var len = arr.length;

        if (from < 0) {
            from += len;
        }

        for (; from < len; from += 1) {
            if (arr.hasOwnProperty(from) && arr[from] === elt) {
                return from;
            }
        }
        return -1;
    };

    //this is a version 4 UUID
    qq.getUniqueId = function() {
        return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function(c) {
            /*jslint eqeq: true, bitwise: true*/
            var r = Math.random() * 16 | 0, v = c == "x" ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    };

    //
    // Browsers and platforms detection
    qq.ie = function() {
        return navigator.userAgent.indexOf("MSIE") !== -1 ||
            navigator.userAgent.indexOf("Trident") !== -1;
    };

    qq.ie7 = function() {
        return navigator.userAgent.indexOf("MSIE 7") !== -1;
    };

    qq.ie8 = function() {
        return navigator.userAgent.indexOf("MSIE 8") !== -1;
    };

    qq.ie10 = function() {
        return navigator.userAgent.indexOf("MSIE 10") !== -1;
    };

    qq.ie11 = function() {
        return qq.ie() && navigator.userAgent.indexOf("rv:11") !== -1;
    };

    qq.edge = function() {
        return navigator.userAgent.indexOf("Edge") >= 0;
    };

    qq.safari = function() {
        return navigator.vendor !== undefined && navigator.vendor.indexOf("Apple") !== -1;
    };

    qq.chrome = function() {
        return navigator.vendor !== undefined && navigator.vendor.indexOf("Google") !== -1;
    };

    qq.opera = function() {
        return navigator.vendor !== undefined && navigator.vendor.indexOf("Opera") !== -1;
    };

    qq.firefox = function() {
        return (!qq.edge() && !qq.ie11() && navigator.userAgent.indexOf("Mozilla") !== -1 && navigator.vendor !== undefined && navigator.vendor === "");
    };

    qq.windows = function() {
        return navigator.platform === "Win32";
    };

    qq.android = function() {
        return navigator.userAgent.toLowerCase().indexOf("android") !== -1;
    };

    // We need to identify the Android stock browser via the UA string to work around various bugs in this browser,
    // such as the one that prevents a `Blob` from being uploaded.
    qq.androidStock = function() {
        return qq.android() && navigator.userAgent.toLowerCase().indexOf("chrome") < 0;
    };

    qq.ios6 = function() {
        return qq.ios() && navigator.userAgent.indexOf(" OS 6_") !== -1;
    };

    qq.ios7 = function() {
        return qq.ios() && navigator.userAgent.indexOf(" OS 7_") !== -1;
    };

    qq.ios8 = function() {
        return qq.ios() && navigator.userAgent.indexOf(" OS 8_") !== -1;
    };

    // iOS 8.0.0
    qq.ios800 = function() {
        return qq.ios() && navigator.userAgent.indexOf(" OS 8_0 ") !== -1;
    };

    qq.ios = function() {
        /*jshint -W014 */
        return navigator.userAgent.indexOf("iPad") !== -1
            || navigator.userAgent.indexOf("iPod") !== -1
            || navigator.userAgent.indexOf("iPhone") !== -1;
    };

    qq.iosChrome = function() {
        return qq.ios() && navigator.userAgent.indexOf("CriOS") !== -1;
    };

    qq.iosSafari = function() {
        return qq.ios() && !qq.iosChrome() && navigator.userAgent.indexOf("Safari") !== -1;
    };

    qq.iosSafariWebView = function() {
        return qq.ios() && !qq.iosChrome() && !qq.iosSafari();
    };

    //
    // Events

    qq.preventDefault = function(e) {
        if (e.preventDefault) {
            e.preventDefault();
        } else {
            e.returnValue = false;
        }
    };

    /**
     * Creates and returns element from html string
     * Uses innerHTML to create an element
     */
    qq.toElement = (function() {
        var div = document.createElement("div");
        return function(html) {
            div.innerHTML = html;
            var element = div.firstChild;
            div.removeChild(element);
            return element;
        };
    }());

    //key and value are passed to callback for each entry in the iterable item
    qq.each = function(iterableItem, callback) {
        var keyOrIndex, retVal;

        if (iterableItem) {
            // Iterate through [`Storage`](http://www.w3.org/TR/webstorage/#the-storage-interface) items
            if (window.Storage && iterableItem.constructor === window.Storage) {
                for (keyOrIndex = 0; keyOrIndex < iterableItem.length; keyOrIndex++) {
                    retVal = callback(iterableItem.key(keyOrIndex), iterableItem.getItem(iterableItem.key(keyOrIndex)));
                    if (retVal === false) {
                        break;
                    }
                }
            }
            // `DataTransferItemList` & `NodeList` objects are array-like and should be treated as arrays
            // when iterating over items inside the object.
            else if (qq.isArray(iterableItem) || qq.isItemList(iterableItem) || qq.isNodeList(iterableItem)) {
                for (keyOrIndex = 0; keyOrIndex < iterableItem.length; keyOrIndex++) {
                    retVal = callback(keyOrIndex, iterableItem[keyOrIndex]);
                    if (retVal === false) {
                        break;
                    }
                }
            }
            else if (qq.isString(iterableItem)) {
                for (keyOrIndex = 0; keyOrIndex < iterableItem.length; keyOrIndex++) {
                    retVal = callback(keyOrIndex, iterableItem.charAt(keyOrIndex));
                    if (retVal === false) {
                        break;
                    }
                }
            }
            else {
                for (keyOrIndex in iterableItem) {
                    if (Object.prototype.hasOwnProperty.call(iterableItem, keyOrIndex)) {
                        retVal = callback(keyOrIndex, iterableItem[keyOrIndex]);
                        if (retVal === false) {
                            break;
                        }
                    }
                }
            }
        }
    };

    //include any args that should be passed to the new function after the context arg
    qq.bind = function(oldFunc, context) {
        if (qq.isFunction(oldFunc)) {
            var args =  Array.prototype.slice.call(arguments, 2);

            return function() {
                var newArgs = qq.extend([], args);
                if (arguments.length) {
                    newArgs = newArgs.concat(Array.prototype.slice.call(arguments));
                }
                return oldFunc.apply(context, newArgs);
            };
        }

        throw new Error("first parameter must be a function!");
    };

    /**
     * obj2url() takes a json-object as argument and generates
     * a querystring. pretty much like jQuery.param()
     *
     * how to use:
     *
     *    `qq.obj2url({a:'b',c:'d'},'http://any.url/upload?otherParam=value');`
     *
     * will result in:
     *
     *    `http://any.url/upload?otherParam=value&a=b&c=d`
     *
     * @param  Object JSON-Object
     * @param  String current querystring-part
     * @return String encoded querystring
     */
    qq.obj2url = function(obj, temp, prefixDone) {
        /*jshint laxbreak: true*/
        var uristrings = [],
            prefix = "&",
            add = function(nextObj, i) {
                var nextTemp = temp
                    ? (/\[\]$/.test(temp)) // prevent double-encoding
                    ? temp
                    : temp + "[" + i + "]"
                    : i;
                if ((nextTemp !== "undefined") && (i !== "undefined")) {
                    uristrings.push(
                        (typeof nextObj === "object")
                            ? qq.obj2url(nextObj, nextTemp, true)
                            : (Object.prototype.toString.call(nextObj) === "[object Function]")
                            ? encodeURIComponent(nextTemp) + "=" + encodeURIComponent(nextObj())
                            : encodeURIComponent(nextTemp) + "=" + encodeURIComponent(nextObj)
                    );
                }
            };

        if (!prefixDone && temp) {
            prefix = (/\?/.test(temp)) ? (/\?$/.test(temp)) ? "" : "&" : "?";
            uristrings.push(temp);
            uristrings.push(qq.obj2url(obj));
        } else if ((Object.prototype.toString.call(obj) === "[object Array]") && (typeof obj !== "undefined")) {
            qq.each(obj, function(idx, val) {
                add(val, idx);
            });
        } else if ((typeof obj !== "undefined") && (obj !== null) && (typeof obj === "object")) {
            qq.each(obj, function(prop, val) {
                add(val, prop);
            });
        } else {
            uristrings.push(encodeURIComponent(temp) + "=" + encodeURIComponent(obj));
        }

        if (temp) {
            return uristrings.join(prefix);
        } else {
            return uristrings.join(prefix)
                .replace(/^&/, "")
                .replace(/%20/g, "+");
        }
    };

    qq.obj2FormData = function(obj, formData, arrayKeyName) {
        if (!formData) {
            formData = new FormData();
        }

        qq.each(obj, function(key, val) {
            key = arrayKeyName ? arrayKeyName + "[" + key + "]" : key;

            if (qq.isObject(val)) {
                qq.obj2FormData(val, formData, key);
            }
            else if (qq.isFunction(val)) {
                formData.append(key, val());
            }
            else {
                formData.append(key, val);
            }
        });

        return formData;
    };

    qq.obj2Inputs = function(obj, form) {
        var input;

        if (!form) {
            form = document.createElement("form");
        }

        qq.obj2FormData(obj, {
            append: function(key, val) {
                input = document.createElement("input");
                input.setAttribute("name", key);
                input.setAttribute("value", val);
                form.appendChild(input);
            }
        });

        return form;
    };

    /**
     * Not recommended for use outside of Fine Uploader since this falls back to an unchecked eval if JSON.parse is not
     * implemented.  For a more secure JSON.parse polyfill, use Douglas Crockford's json2.js.
     */
    qq.parseJson = function(json) {
        /*jshint evil: true*/
        if (window.JSON && qq.isFunction(JSON.parse)) {
            return JSON.parse(json);
        } else {
            return eval("(" + json + ")");
        }
    };

    /**
     * Retrieve the extension of a file, if it exists.
     *
     * @param filename
     * @returns {string || undefined}
     */
    qq.getExtension = function(filename) {
        var extIdx = filename.lastIndexOf(".") + 1;

        if (extIdx > 0) {
            return filename.substr(extIdx, filename.length - extIdx);
        }
    };

    qq.getFilename = function(blobOrFileInput) {
        /*jslint regexp: true*/

        if (qq.isInput(blobOrFileInput)) {
            // get input value and remove path to normalize
            return blobOrFileInput.value.replace(/.*(\/|\\)/, "");
        }
        else if (qq.isFile(blobOrFileInput)) {
            if (blobOrFileInput.fileName !== null && blobOrFileInput.fileName !== undefined) {
                return blobOrFileInput.fileName;
            }
        }

        return blobOrFileInput.name;
    };

    /**
     * A generic module which supports object disposing in dispose() method.
     * */
    qq.DisposeSupport = function() {
        var disposers = [];

        return {
            /** Run all registered disposers */
            dispose: function() {
                var disposer;
                do {
                    disposer = disposers.shift();
                    if (disposer) {
                        disposer();
                    }
                }
                while (disposer);
            },

            /** Attach event handler and register de-attacher as a disposer */
            attach: function() {
                var args = arguments;
                /*jslint undef:true*/
                this.addDisposer(qq(args[0]).attach.apply(this, Array.prototype.slice.call(arguments, 1)));
            },

            /** Add disposer to the collection */
            addDisposer: function(disposeFunction) {
                disposers.push(disposeFunction);
            }
        };
    };
}());

/* globals qq */
/**
 * Fine Uploader top-level Error container.  Inherits from `Error`.
 */
(function() {
    "use strict";

    qq.Error = function(message) {
        this.message = "[Fine Uploader " + qq.version + "] " + message;
    };

    qq.Error.prototype = new Error();
}());

/*global qq */
qq.version = "5.10.0";

/* globals qq */
qq.supportedFeatures = (function() {
    "use strict";

    var supportsUploading,
        supportsUploadingBlobs,
        supportsFileDrop,
        supportsAjaxFileUploading,
        supportsFolderDrop,
        supportsChunking,
        supportsResume,
        supportsUploadViaPaste,
        supportsUploadCors,
        supportsDeleteFileXdr,
        supportsDeleteFileCorsXhr,
        supportsDeleteFileCors,
        supportsFolderSelection,
        supportsImagePreviews,
        supportsUploadProgress;

    function testSupportsFileInputElement() {
        var supported = true,
            tempInput;

        try {
            tempInput = document.createElement("input");
            tempInput.type = "file";
            qq(tempInput).hide();

            if (tempInput.disabled) {
                supported = false;
            }
        }
        catch (ex) {
            supported = false;
        }

        return supported;
    }

    //only way to test for Filesystem API support since webkit does not expose the DataTransfer interface
    function isChrome21OrHigher() {
        return (qq.chrome() || qq.opera()) &&
            navigator.userAgent.match(/Chrome\/[2][1-9]|Chrome\/[3-9][0-9]/) !== undefined;
    }

    //only way to test for complete Clipboard API support at this time
    function isChrome14OrHigher() {
        return (qq.chrome() || qq.opera()) &&
            navigator.userAgent.match(/Chrome\/[1][4-9]|Chrome\/[2-9][0-9]/) !== undefined;
    }

    //Ensure we can send cross-origin `XMLHttpRequest`s
    function isCrossOriginXhrSupported() {
        if (window.XMLHttpRequest) {
            var xhr = qq.createXhrInstance();

            //Commonly accepted test for XHR CORS support.
            return xhr.withCredentials !== undefined;
        }

        return false;
    }

    //Test for (terrible) cross-origin ajax transport fallback for IE9 and IE8
    function isXdrSupported() {
        return window.XDomainRequest !== undefined;
    }

    // CORS Ajax requests are supported if it is either possible to send credentialed `XMLHttpRequest`s,
    // or if `XDomainRequest` is an available alternative.
    function isCrossOriginAjaxSupported() {
        if (isCrossOriginXhrSupported()) {
            return true;
        }

        return isXdrSupported();
    }

    function isFolderSelectionSupported() {
        // We know that folder selection is only supported in Chrome via this proprietary attribute for now
        return document.createElement("input").webkitdirectory !== undefined;
    }

    function isLocalStorageSupported() {
        try {
            return !!window.localStorage &&
                // unpatched versions of IE10/11 have buggy impls of localStorage where setItem is a string
                qq.isFunction(window.localStorage.setItem);
        }
        catch (error) {
            // probably caught a security exception, so no localStorage for you
            return false;
        }
    }

    function isDragAndDropSupported() {
        var span = document.createElement("span");

        return ("draggable" in span || ("ondragstart" in span && "ondrop" in span)) &&
            !qq.android() && !qq.ios();
    }

    supportsUploading = testSupportsFileInputElement();

    supportsAjaxFileUploading = supportsUploading && qq.isXhrUploadSupported();

    supportsUploadingBlobs = supportsAjaxFileUploading && !qq.androidStock();

    supportsFileDrop = supportsAjaxFileUploading && isDragAndDropSupported();

    supportsFolderDrop = supportsFileDrop && isChrome21OrHigher();

    supportsChunking = supportsAjaxFileUploading && qq.isFileChunkingSupported();

    supportsResume = supportsAjaxFileUploading && supportsChunking && isLocalStorageSupported();

    supportsUploadViaPaste = supportsAjaxFileUploading && isChrome14OrHigher();

    supportsUploadCors = supportsUploading && (window.postMessage !== undefined || supportsAjaxFileUploading);

    supportsDeleteFileCorsXhr = isCrossOriginXhrSupported();

    supportsDeleteFileXdr = isXdrSupported();

    supportsDeleteFileCors = isCrossOriginAjaxSupported();

    supportsFolderSelection = isFolderSelectionSupported();

    supportsImagePreviews = supportsAjaxFileUploading && window.FileReader !== undefined;

    supportsUploadProgress = (function() {
        if (supportsAjaxFileUploading) {
            return !qq.androidStock() && !qq.iosChrome();
        }
        return false;
    }());

    return {
        ajaxUploading: supportsAjaxFileUploading,
        blobUploading: supportsUploadingBlobs,
        canDetermineSize: supportsAjaxFileUploading,
        chunking: supportsChunking,
        deleteFileCors: supportsDeleteFileCors,
        deleteFileCorsXdr: supportsDeleteFileXdr, //NOTE: will also return true in IE10, where XDR is also supported
        deleteFileCorsXhr: supportsDeleteFileCorsXhr,
        dialogElement: !!window.HTMLDialogElement,
        fileDrop: supportsFileDrop,
        folderDrop: supportsFolderDrop,
        folderSelection: supportsFolderSelection,
        imagePreviews: supportsImagePreviews,
        imageValidation: supportsImagePreviews,
        itemSizeValidation: supportsAjaxFileUploading,
        pause: supportsChunking,
        progressBar: supportsUploadProgress,
        resume: supportsResume,
        scaling: supportsImagePreviews && supportsUploadingBlobs,
        tiffPreviews: qq.safari(), // Not the best solution, but simple and probably accurate enough (for now)
        unlimitedScaledImageSize: !qq.ios(), // false simply indicates that there is some known limit
        uploading: supportsUploading,
        uploadCors: supportsUploadCors,
        uploadCustomHeaders: supportsAjaxFileUploading,
        uploadNonMultipart: supportsAjaxFileUploading,
        uploadViaPaste: supportsUploadViaPaste
    };

}());

/*globals qq*/

// Is the passed object a promise instance?
qq.isGenericPromise = function(maybePromise) {
    "use strict";
    return !!(maybePromise && maybePromise.then && qq.isFunction(maybePromise.then));
};

qq.Promise = function() {
    "use strict";

    var successArgs, failureArgs,
        successCallbacks = [],
        failureCallbacks = [],
        doneCallbacks = [],
        state = 0;

    qq.extend(this, {
        then: function(onSuccess, onFailure) {
            if (state === 0) {
                if (onSuccess) {
                    successCallbacks.push(onSuccess);
                }
                if (onFailure) {
                    failureCallbacks.push(onFailure);
                }
            }
            else if (state === -1) {
                onFailure && onFailure.apply(null, failureArgs);
            }
            else if (onSuccess) {
                onSuccess.apply(null, successArgs);
            }

            return this;
        },

        done: function(callback) {
            if (state === 0) {
                doneCallbacks.push(callback);
            }
            else {
                callback.apply(null, failureArgs === undefined ? successArgs : failureArgs);
            }

            return this;
        },

        success: function() {
            state = 1;
            successArgs = arguments;

            if (successCallbacks.length) {
                qq.each(successCallbacks, function(idx, callback) {
                    callback.apply(null, successArgs);
                });
            }

            if (doneCallbacks.length) {
                qq.each(doneCallbacks, function(idx, callback) {
                    callback.apply(null, successArgs);
                });
            }

            return this;
        },

        failure: function() {
            state = -1;
            failureArgs = arguments;

            if (failureCallbacks.length) {
                qq.each(failureCallbacks, function(idx, callback) {
                    callback.apply(null, failureArgs);
                });
            }

            if (doneCallbacks.length) {
                qq.each(doneCallbacks, function(idx, callback) {
                    callback.apply(null, failureArgs);
                });
            }

            return this;
        }
    });
};

/* globals qq */
/**
 * Placeholder for a Blob that will be generated on-demand.
 *
 * @param referenceBlob Parent of the generated blob
 * @param onCreate Function to invoke when the blob must be created.  Must be promissory.
 * @constructor
 */
qq.BlobProxy = function(referenceBlob, onCreate) {
    "use strict";

    qq.extend(this, {
        referenceBlob: referenceBlob,

        create: function() {
            return onCreate(referenceBlob);
        }
    });
};

/*globals qq*/

/**
 * This module represents an upload or "Select File(s)" button.  It's job is to embed an opaque `<input type="file">`
 * element as a child of a provided "container" element.  This "container" element (`options.element`) is used to provide
 * a custom style for the `<input type="file">` element.  The ability to change the style of the container element is also
 * provided here by adding CSS classes to the container on hover/focus.
 *
 * TODO Eliminate the mouseover and mouseout event handlers since the :hover CSS pseudo-class should now be
 * available on all supported browsers.
 *
 * @param o Options to override the default values
 */
qq.UploadButton = function(o) {
    "use strict";

    var self = this,

        disposeSupport = new qq.DisposeSupport(),

        options = {
            // Corresponds to the `accept` attribute on the associated `<input type="file">`
            acceptFiles: null,

            // "Container" element
            element: null,

            focusClass: "qq-upload-button-focus",

            // A true value allows folders to be selected, if supported by the UA
            folders: false,

            // **This option will be removed** in the future as the :hover CSS pseudo-class is available on all supported browsers
            hoverClass: "qq-upload-button-hover",

            ios8BrowserCrashWorkaround: false,

            // If true adds `multiple` attribute to `<input type="file">`
            multiple: false,

            // `name` attribute of `<input type="file">`
            name: "qqfile",

            // Called when the browser invokes the onchange handler on the `<input type="file">`
            onChange: function(input) {},

            title: null
        },
        input, buttonId;

    // Overrides any of the default option values with any option values passed in during construction.
    qq.extend(options, o);

    buttonId = qq.getUniqueId();

    // Embed an opaque `<input type="file">` element as a child of `options.element`.
    function createInput() {
        var input = document.createElement("input");

        input.setAttribute(qq.UploadButton.BUTTON_ID_ATTR_NAME, buttonId);
        input.setAttribute("title", options.title);

        self.setMultiple(options.multiple, input);

        if (options.folders && qq.supportedFeatures.folderSelection) {
            // selecting directories is only possible in Chrome now, via a vendor-specific prefixed attribute
            input.setAttribute("webkitdirectory", "");
        }

        if (options.acceptFiles) {
            input.setAttribute("accept", options.acceptFiles);
        }

        input.setAttribute("type", "file");
        input.setAttribute("name", options.name);

        qq(input).css({
            position: "absolute",
            // in Opera only 'browse' button
            // is clickable and it is located at
            // the right side of the input
            right: 0,
            top: 0,
            fontFamily: "Arial",
            // It's especially important to make this an arbitrarily large value
            // to ensure the rendered input button in IE takes up the entire
            // space of the container element.  Otherwise, the left side of the
            // button will require a double-click to invoke the file chooser.
            // In other browsers, this might cause other issues, so a large font-size
            // is only used in IE.  There is a bug in IE8 where the opacity style is  ignored
            // in some cases when the font-size is large.  So, this workaround is not applied
            // to IE8.
            fontSize: qq.ie() && !qq.ie8() ? "3500px" : "118px",
            margin: 0,
            padding: 0,
            cursor: "pointer",
            opacity: 0
        });

        // Setting the file input's height to 100% in IE7 causes
        // most of the visible button to be unclickable.
        !qq.ie7() && qq(input).css({height: "100%"});

        options.element.appendChild(input);

        disposeSupport.attach(input, "change", function() {
            options.onChange(input);
        });

        // **These event handlers will be removed** in the future as the :hover CSS pseudo-class is available on all supported browsers
        disposeSupport.attach(input, "mouseover", function() {
            qq(options.element).addClass(options.hoverClass);
        });
        disposeSupport.attach(input, "mouseout", function() {
            qq(options.element).removeClass(options.hoverClass);
        });

        disposeSupport.attach(input, "focus", function() {
            qq(options.element).addClass(options.focusClass);
        });
        disposeSupport.attach(input, "blur", function() {
            qq(options.element).removeClass(options.focusClass);
        });

        return input;
    }

    // Make button suitable container for input
    qq(options.element).css({
        position: "relative",
        overflow: "hidden",
        // Make sure browse button is in the right side in Internet Explorer
        direction: "ltr"
    });

    // Exposed API
    qq.extend(this, {
        getInput: function() {
            return input;
        },

        getButtonId: function() {
            return buttonId;
        },

        setMultiple: function(isMultiple, optInput) {
            var input = optInput || this.getInput();

            // Temporary workaround for bug in in iOS8 UIWebView that causes the browser to crash
            // before the file chooser appears if the file input doesn't contain a multiple attribute.
            // See #1283.
            if (options.ios8BrowserCrashWorkaround && qq.ios8() && (qq.iosChrome() || qq.iosSafariWebView())) {
                input.setAttribute("multiple", "");
            }

            else {
                if (isMultiple) {
                    input.setAttribute("multiple", "");
                }
                else {
                    input.removeAttribute("multiple");
                }
            }
        },

        setAcceptFiles: function(acceptFiles) {
            if (acceptFiles !== options.acceptFiles) {
                input.setAttribute("accept", acceptFiles);
            }
        },

        reset: function() {
            if (input.parentNode) {
                qq(input).remove();
            }

            qq(options.element).removeClass(options.focusClass);
            input = null;
            input = createInput();
        }
    });

    input = createInput();
};

qq.UploadButton.BUTTON_ID_ATTR_NAME = "qq-button-id";

/*globals qq */
qq.UploadData = function(uploaderProxy) {
    "use strict";

    var data = [],
        byUuid = {},
        byStatus = {},
        byProxyGroupId = {},
        byBatchId = {};

    function getDataByIds(idOrIds) {
        if (qq.isArray(idOrIds)) {
            var entries = [];

            qq.each(idOrIds, function(idx, id) {
                entries.push(data[id]);
            });

            return entries;
        }

        return data[idOrIds];
    }

    function getDataByUuids(uuids) {
        if (qq.isArray(uuids)) {
            var entries = [];

            qq.each(uuids, function(idx, uuid) {
                entries.push(data[byUuid[uuid]]);
            });

            return entries;
        }

        return data[byUuid[uuids]];
    }

    function getDataByStatus(status) {
        var statusResults = [],
            statuses = [].concat(status);

        qq.each(statuses, function(index, statusEnum) {
            var statusResultIndexes = byStatus[statusEnum];

            if (statusResultIndexes !== undefined) {
                qq.each(statusResultIndexes, function(i, dataIndex) {
                    statusResults.push(data[dataIndex]);
                });
            }
        });

        return statusResults;
    }

    qq.extend(this, {
        /**
         * Adds a new file to the data cache for tracking purposes.
         *
         * @param spec Data that describes this file.  Possible properties are:
         *
         * - uuid: Initial UUID for this file.
         * - name: Initial name of this file.
         * - size: Size of this file, omit if this cannot be determined
         * - status: Initial `qq.status` for this file.  Omit for `qq.status.SUBMITTING`.
         * - batchId: ID of the batch this file belongs to
         * - proxyGroupId: ID of the proxy group associated with this file
         *
         * @returns {number} Internal ID for this file.
         */
        addFile: function(spec) {
            var status = spec.status || qq.status.SUBMITTING,
                id = data.push({
                    name: spec.name,
                    originalName: spec.name,
                    uuid: spec.uuid,
                    size: spec.size == null ? -1 : spec.size,
                    status: status
                }) - 1;

            if (spec.batchId) {
                data[id].batchId = spec.batchId;

                if (byBatchId[spec.batchId] === undefined) {
                    byBatchId[spec.batchId] = [];
                }
                byBatchId[spec.batchId].push(id);
            }

            if (spec.proxyGroupId) {
                data[id].proxyGroupId = spec.proxyGroupId;

                if (byProxyGroupId[spec.proxyGroupId] === undefined) {
                    byProxyGroupId[spec.proxyGroupId] = [];
                }
                byProxyGroupId[spec.proxyGroupId].push(id);
            }

            data[id].id = id;
            byUuid[spec.uuid] = id;

            if (byStatus[status] === undefined) {
                byStatus[status] = [];
            }
            byStatus[status].push(id);

            uploaderProxy.onStatusChange(id, null, status);

            return id;
        },

        retrieve: function(optionalFilter) {
            if (qq.isObject(optionalFilter) && data.length)  {
                if (optionalFilter.id !== undefined) {
                    return getDataByIds(optionalFilter.id);
                }

                else if (optionalFilter.uuid !== undefined) {
                    return getDataByUuids(optionalFilter.uuid);
                }

                else if (optionalFilter.status) {
                    return getDataByStatus(optionalFilter.status);
                }
            }
            else {
                return qq.extend([], data, true);
            }
        },

        reset: function() {
            data = [];
            byUuid = {};
            byStatus = {};
            byBatchId = {};
        },

        setStatus: function(id, newStatus) {
            var oldStatus = data[id].status,
                byStatusOldStatusIndex = qq.indexOf(byStatus[oldStatus], id);

            byStatus[oldStatus].splice(byStatusOldStatusIndex, 1);

            data[id].status = newStatus;

            if (byStatus[newStatus] === undefined) {
                byStatus[newStatus] = [];
            }
            byStatus[newStatus].push(id);

            uploaderProxy.onStatusChange(id, oldStatus, newStatus);
        },

        uuidChanged: function(id, newUuid) {
            var oldUuid = data[id].uuid;

            data[id].uuid = newUuid;
            byUuid[newUuid] = id;
            delete byUuid[oldUuid];
        },

        updateName: function(id, newName) {
            data[id].name = newName;
        },

        updateSize: function(id, newSize) {
            data[id].size = newSize;
        },

        // Only applicable if this file has a parent that we may want to reference later.
        setParentId: function(targetId, parentId) {
            data[targetId].parentId = parentId;
        },

        getIdsInProxyGroup: function(id) {
            var proxyGroupId = data[id].proxyGroupId;

            if (proxyGroupId) {
                return byProxyGroupId[proxyGroupId];
            }
            return [];
        },

        getIdsInBatch: function(id) {
            var batchId = data[id].batchId;

            return byBatchId[batchId];
        }
    });
};

qq.status = {
    SUBMITTING: "submitting",
    SUBMITTED: "submitted",
    REJECTED: "rejected",
    QUEUED: "queued",
    CANCELED: "canceled",
    PAUSED: "paused",
    UPLOADING: "uploading",
    UPLOAD_RETRYING: "retrying upload",
    UPLOAD_SUCCESSFUL: "upload successful",
    UPLOAD_FAILED: "upload failed",
    DELETE_FAILED: "delete failed",
    DELETING: "deleting",
    DELETED: "deleted"
};

/*globals qq*/
/**
 * Defines the public API for FineUploaderBasic mode.
 */
(function() {
    "use strict";

    qq.basePublicApi = {
        // DEPRECATED - TODO REMOVE IN NEXT MAJOR RELEASE (replaced by addFiles)
        addBlobs: function(blobDataOrArray, params, endpoint) {
            this.addFiles(blobDataOrArray, params, endpoint);
        },

        addInitialFiles: function(cannedFileList) {
            var self = this;

            qq.each(cannedFileList, function(index, cannedFile) {
                self._addCannedFile(cannedFile);
            });
        },

        addFiles: function(data, params, endpoint) {
            this._maybeHandleIos8SafariWorkaround();

            var batchId = this._storedIds.length === 0 ? qq.getUniqueId() : this._currentBatchId,

                processBlob = qq.bind(function(blob) {
                    this._handleNewFile({
                        blob: blob,
                        name: this._options.blobs.defaultName
                    }, batchId, verifiedFiles);
                }, this),

                processBlobData = qq.bind(function(blobData) {
                    this._handleNewFile(blobData, batchId, verifiedFiles);
                }, this),

                processCanvas = qq.bind(function(canvas) {
                    var blob = qq.canvasToBlob(canvas);

                    this._handleNewFile({
                        blob: blob,
                        name: this._options.blobs.defaultName + ".png"
                    }, batchId, verifiedFiles);
                }, this),

                processCanvasData = qq.bind(function(canvasData) {
                    var normalizedQuality = canvasData.quality && canvasData.quality / 100,
                        blob = qq.canvasToBlob(canvasData.canvas, canvasData.type, normalizedQuality);

                    this._handleNewFile({
                        blob: blob,
                        name: canvasData.name
                    }, batchId, verifiedFiles);
                }, this),

                processFileOrInput = qq.bind(function(fileOrInput) {
                    if (qq.isInput(fileOrInput) && qq.supportedFeatures.ajaxUploading) {
                        var files = Array.prototype.slice.call(fileOrInput.files),
                            self = this;

                        qq.each(files, function(idx, file) {
                            self._handleNewFile(file, batchId, verifiedFiles);
                        });
                    }
                    else {
                        this._handleNewFile(fileOrInput, batchId, verifiedFiles);
                    }
                }, this),

                normalizeData = function() {
                    if (qq.isFileList(data)) {
                        data = Array.prototype.slice.call(data);
                    }
                    data = [].concat(data);
                },

                self = this,
                verifiedFiles = [];

            this._currentBatchId = batchId;

            if (data) {
                normalizeData();

                qq.each(data, function(idx, fileContainer) {
                    if (qq.isFileOrInput(fileContainer)) {
                        processFileOrInput(fileContainer);
                    }
                    else if (qq.isBlob(fileContainer)) {
                        processBlob(fileContainer);
                    }
                    else if (qq.isObject(fileContainer)) {
                        if (fileContainer.blob && fileContainer.name) {
                            processBlobData(fileContainer);
                        }
                        else if (fileContainer.canvas && fileContainer.name) {
                            processCanvasData(fileContainer);
                        }
                    }
                    else if (fileContainer.tagName && fileContainer.tagName.toLowerCase() === "canvas") {
                        processCanvas(fileContainer);
                    }
                    else {
                        self.log(fileContainer + " is not a valid file container!  Ignoring!", "warn");
                    }
                });

                this.log("Received " + verifiedFiles.length + " files.");
                this._prepareItemsForUpload(verifiedFiles, params, endpoint);
            }
        },

        cancel: function(id) {
            this._handler.cancel(id);
        },

        cancelAll: function() {
            var storedIdsCopy = [],
                self = this;

            qq.extend(storedIdsCopy, this._storedIds);
            qq.each(storedIdsCopy, function(idx, storedFileId) {
                self.cancel(storedFileId);
            });

            this._handler.cancelAll();
        },

        clearStoredFiles: function() {
            this._storedIds = [];
        },

        continueUpload: function(id) {
            var uploadData = this._uploadData.retrieve({id: id});

            if (!qq.supportedFeatures.pause || !this._options.chunking.enabled) {
                return false;
            }

            if (uploadData.status === qq.status.PAUSED) {
                this.log(qq.format("Paused file ID {} ({}) will be continued.  Not paused.", id, this.getName(id)));
                this._uploadFile(id);
                return true;
            }
            else {
                this.log(qq.format("Ignoring continue for file ID {} ({}).  Not paused.", id, this.getName(id)), "error");
            }

            return false;
        },

        deleteFile: function(id) {
            return this._onSubmitDelete(id);
        },

        // TODO document?
        doesExist: function(fileOrBlobId) {
            return this._handler.isValid(fileOrBlobId);
        },

        // Generate a variable size thumbnail on an img or canvas,
        // returning a promise that is fulfilled when the attempt completes.
        // Thumbnail can either be based off of a URL for an image returned
        // by the server in the upload response, or the associated `Blob`.
        drawThumbnail: function(fileId, imgOrCanvas, maxSize, fromServer, customResizeFunction) {
            var promiseToReturn = new qq.Promise(),
                fileOrUrl, options;

            if (this._imageGenerator) {
                fileOrUrl = this._thumbnailUrls[fileId];
                options = {
                    customResizeFunction: customResizeFunction,
                    maxSize: maxSize > 0 ? maxSize : null,
                    scale: maxSize > 0
                };

                // If client-side preview generation is possible
                // and we are not specifically looking for the image URl returned by the server...
                if (!fromServer && qq.supportedFeatures.imagePreviews) {
                    fileOrUrl = this.getFile(fileId);
                }

                /* jshint eqeqeq:false,eqnull:true */
                if (fileOrUrl == null) {
                    promiseToReturn.failure({container: imgOrCanvas, error: "File or URL not found."});
                }
                else {
                    this._imageGenerator.generate(fileOrUrl, imgOrCanvas, options).then(
                        function success(modifiedContainer) {
                            promiseToReturn.success(modifiedContainer);
                        },

                        function failure(container, reason) {
                            promiseToReturn.failure({container: container, error: reason || "Problem generating thumbnail"});
                        }
                    );
                }
            }
            else {
                promiseToReturn.failure({container: imgOrCanvas, error: "Missing image generator module"});
            }

            return promiseToReturn;
        },

        getButton: function(fileId) {
            return this._getButton(this._buttonIdsForFileIds[fileId]);
        },

        getEndpoint: function(fileId) {
            return this._endpointStore.get(fileId);
        },

        getFile: function(fileOrBlobId) {
            return this._handler.getFile(fileOrBlobId) || null;
        },

        getInProgress: function() {
            return this._uploadData.retrieve({
                status: [
                    qq.status.UPLOADING,
                    qq.status.UPLOAD_RETRYING,
                    qq.status.QUEUED
                ]
            }).length;
        },

        getName: function(id) {
            return this._uploadData.retrieve({id: id}).name;
        },

                // Parent ID for a specific file, or null if this is the parent, or if it has no parent.
        getParentId: function(id) {
            var uploadDataEntry = this.getUploads({id: id}),
                parentId = null;

            if (uploadDataEntry) {
                if (uploadDataEntry.parentId !== undefined) {
                    parentId = uploadDataEntry.parentId;
                }
            }

            return parentId;
        },

        getResumableFilesData: function() {
            return this._handler.getResumableFilesData();
        },

        getSize: function(id) {
            return this._uploadData.retrieve({id: id}).size;
        },

        getNetUploads: function() {
            return this._netUploaded;
        },

        getRemainingAllowedItems: function() {
            var allowedItems = this._currentItemLimit;

            if (allowedItems > 0) {
                return allowedItems - this._netUploadedOrQueued;
            }

            return null;
        },

        getUploads: function(optionalFilter) {
            return this._uploadData.retrieve(optionalFilter);
        },

        getUuid: function(id) {
            return this._uploadData.retrieve({id: id}).uuid;
        },

        log: function(str, level) {
            if (this._options.debug && (!level || level === "info")) {
                qq.log("[Fine Uploader " + qq.version + "] " + str);
            }
            else if (level && level !== "info") {
                qq.log("[Fine Uploader " + qq.version + "] " + str, level);

            }
        },

        pauseUpload: function(id) {
            var uploadData = this._uploadData.retrieve({id: id});

            if (!qq.supportedFeatures.pause || !this._options.chunking.enabled) {
                return false;
            }

            // Pause only really makes sense if the file is uploading or retrying
            if (qq.indexOf([qq.status.UPLOADING, qq.status.UPLOAD_RETRYING], uploadData.status) >= 0) {
                if (this._handler.pause(id)) {
                    this._uploadData.setStatus(id, qq.status.PAUSED);
                    return true;
                }
                else {
                    this.log(qq.format("Unable to pause file ID {} ({}).", id, this.getName(id)), "error");
                }
            }
            else {
                this.log(qq.format("Ignoring pause for file ID {} ({}).  Not in progress.", id, this.getName(id)), "error");
            }

            return false;
        },

        reset: function() {
            this.log("Resetting uploader...");

            this._handler.reset();
            this._storedIds = [];
            this._autoRetries = [];
            this._retryTimeouts = [];
            this._preventRetries = [];
            this._thumbnailUrls = [];

            qq.each(this._buttons, function(idx, button) {
                button.reset();
            });

            this._paramsStore.reset();
            this._endpointStore.reset();
            this._netUploadedOrQueued = 0;
            this._netUploaded = 0;
            this._uploadData.reset();
            this._buttonIdsForFileIds = [];

            this._pasteHandler && this._pasteHandler.reset();
            this._options.session.refreshOnReset && this._refreshSessionData();

            this._succeededSinceLastAllComplete = [];
            this._failedSinceLastAllComplete = [];

            this._totalProgress && this._totalProgress.reset();
        },

        retry: function(id) {
            return this._manualRetry(id);
        },

        scaleImage: function(id, specs) {
            var self = this;

            return qq.Scaler.prototype.scaleImage(id, specs, {
                log: qq.bind(self.log, self),
                getFile: qq.bind(self.getFile, self),
                uploadData: self._uploadData
            });
        },

        setCustomHeaders: function(headers, id) {
            this._customHeadersStore.set(headers, id);
        },

        setDeleteFileCustomHeaders: function(headers, id) {
            this._deleteFileCustomHeadersStore.set(headers, id);
        },

        setDeleteFileEndpoint: function(endpoint, id) {
            this._deleteFileEndpointStore.set(endpoint, id);
        },

        setDeleteFileParams: function(params, id) {
            this._deleteFileParamsStore.set(params, id);
        },

        // Re-sets the default endpoint, an endpoint for a specific file, or an endpoint for a specific button
        setEndpoint: function(endpoint, id) {
            this._endpointStore.set(endpoint, id);
        },

        setForm: function(elementOrId) {
            this._updateFormSupportAndParams(elementOrId);
        },

        setItemLimit: function(newItemLimit) {
            this._currentItemLimit = newItemLimit;
        },

        setName: function(id, newName) {
            this._uploadData.updateName(id, newName);
        },

        setParams: function(params, id) {
            this._paramsStore.set(params, id);
        },

        setUuid: function(id, newUuid) {
            return this._uploadData.uuidChanged(id, newUuid);
        },

        uploadStoredFiles: function() {
            if (this._storedIds.length === 0) {
                this._itemError("noFilesError");
            }
            else {
                this._uploadStoredFiles();
            }
        }
    };

    /**
     * Defines the private (internal) API for FineUploaderBasic mode.
     */
    qq.basePrivateApi = {
        // Updates internal state with a file record (not backed by a live file).  Returns the assigned ID.
        _addCannedFile: function(sessionData) {
            var id = this._uploadData.addFile({
                uuid: sessionData.uuid,
                name: sessionData.name,
                size: sessionData.size,
                status: qq.status.UPLOAD_SUCCESSFUL
            });

            sessionData.deleteFileEndpoint && this.setDeleteFileEndpoint(sessionData.deleteFileEndpoint, id);
            sessionData.deleteFileParams && this.setDeleteFileParams(sessionData.deleteFileParams, id);

            if (sessionData.thumbnailUrl) {
                this._thumbnailUrls[id] = sessionData.thumbnailUrl;
            }

            this._netUploaded++;
            this._netUploadedOrQueued++;

            return id;
        },

        _annotateWithButtonId: function(file, associatedInput) {
            if (qq.isFile(file)) {
                file.qqButtonId = this._getButtonId(associatedInput);
            }
        },

        _batchError: function(message) {
            this._options.callbacks.onError(null, null, message, undefined);
        },

        _createDeleteHandler: function() {
            var self = this;

            return new qq.DeleteFileAjaxRequester({
                method: this._options.deleteFile.method.toUpperCase(),
                maxConnections: this._options.maxConnections,
                uuidParamName: this._options.request.uuidName,
                customHeaders: this._deleteFileCustomHeadersStore,
                paramsStore: this._deleteFileParamsStore,
                endpointStore: this._deleteFileEndpointStore,
                cors: this._options.cors,
                log: qq.bind(self.log, self),
                onDelete: function(id) {
                    self._onDelete(id);
                    self._options.callbacks.onDelete(id);
                },
                onDeleteComplete: function(id, xhrOrXdr, isError) {
                    self._onDeleteComplete(id, xhrOrXdr, isError);
                    self._options.callbacks.onDeleteComplete(id, xhrOrXdr, isError);
                }

            });
        },

        _createPasteHandler: function() {
            var self = this;

            return new qq.PasteSupport({
                targetElement: this._options.paste.targetElement,
                callbacks: {
                    log: qq.bind(self.log, self),
                    pasteReceived: function(blob) {
                        self._handleCheckedCallback({
                            name: "onPasteReceived",
                            callback: qq.bind(self._options.callbacks.onPasteReceived, self, blob),
                            onSuccess: qq.bind(self._handlePasteSuccess, self, blob),
                            identifier: "pasted image"
                        });
                    }
                }
            });
        },

        _createStore: function(initialValue, _readOnlyValues_) {
            var store = {},
                catchall = initialValue,
                perIdReadOnlyValues = {},
                readOnlyValues = _readOnlyValues_,
                copy = function(orig) {
                    if (qq.isObject(orig)) {
                        return qq.extend({}, orig);
                    }
                    return orig;
                },
                getReadOnlyValues = function() {
                    if (qq.isFunction(readOnlyValues)) {
                        return readOnlyValues();
                    }
                    return readOnlyValues;
                },
                includeReadOnlyValues = function(id, existing) {
                    if (readOnlyValues && qq.isObject(existing)) {
                        qq.extend(existing, getReadOnlyValues());
                    }

                    if (perIdReadOnlyValues[id]) {
                        qq.extend(existing, perIdReadOnlyValues[id]);
                    }
                };

            return {
                set: function(val, id) {
                    /*jshint eqeqeq: true, eqnull: true*/
                    if (id == null) {
                        store = {};
                        catchall = copy(val);
                    }
                    else {
                        store[id] = copy(val);
                    }
                },

                get: function(id) {
                    var values;

                    /*jshint eqeqeq: true, eqnull: true*/
                    if (id != null && store[id]) {
                        values = store[id];
                    }
                    else {
                        values = copy(catchall);
                    }

                    includeReadOnlyValues(id, values);

                    return copy(values);
                },

                addReadOnly: function(id, values) {
                    // Only applicable to Object stores
                    if (qq.isObject(store)) {
                        // If null ID, apply readonly values to all files
                        if (id === null) {
                            if (qq.isFunction(values)) {
                                readOnlyValues = values;
                            }
                            else {
                                readOnlyValues = readOnlyValues || {};
                                qq.extend(readOnlyValues, values);
                            }
                        }
                        else {
                            perIdReadOnlyValues[id] = perIdReadOnlyValues[id] || {};
                            qq.extend(perIdReadOnlyValues[id], values);
                        }
                    }
                },

                remove: function(fileId) {
                    return delete store[fileId];
                },

                reset: function() {
                    store = {};
                    perIdReadOnlyValues = {};
                    catchall = initialValue;
                }
            };
        },

        _createUploadDataTracker: function() {
            var self = this;

            return new qq.UploadData({
                getName: function(id) {
                    return self.getName(id);
                },
                getUuid: function(id) {
                    return self.getUuid(id);
                },
                getSize: function(id) {
                    return self.getSize(id);
                },
                onStatusChange: function(id, oldStatus, newStatus) {
                    self._onUploadStatusChange(id, oldStatus, newStatus);
                    self._options.callbacks.onStatusChange(id, oldStatus, newStatus);
                    self._maybeAllComplete(id, newStatus);

                    if (self._totalProgress) {
                        setTimeout(function() {
                            self._totalProgress.onStatusChange(id, oldStatus, newStatus);
                        }, 0);
                    }
                }
            });
        },

        /**
         * Generate a tracked upload button.
         *
         * @param spec Object containing a required `element` property
         * along with optional `multiple`, `accept`, and `folders`.
         * @returns {qq.UploadButton}
         * @private
         */
        _createUploadButton: function(spec) {
            var self = this,
                acceptFiles = spec.accept || this._options.validation.acceptFiles,
                allowedExtensions = spec.allowedExtensions || this._options.validation.allowedExtensions,
                button;

            function allowMultiple() {
                if (qq.supportedFeatures.ajaxUploading) {
                    // Workaround for bug in iOS7+ (see #1039)
                    if (self._options.workarounds.iosEmptyVideos &&
                        qq.ios() &&
                        !qq.ios6() &&
                        self._isAllowedExtension(allowedExtensions, ".mov")) {

                        return false;
                    }

                    if (spec.multiple === undefined) {
                        return self._options.multiple;
                    }

                    return spec.multiple;
                }

                return false;
            }

            button = new qq.UploadButton({
                acceptFiles: acceptFiles,
                element: spec.element,
                focusClass: this._options.classes.buttonFocus,
                folders: spec.folders,
                hoverClass: this._options.classes.buttonHover,
                ios8BrowserCrashWorkaround: this._options.workarounds.ios8BrowserCrash,
                multiple: allowMultiple(),
                name: this._options.request.inputName,
                onChange: function(input) {
                    self._onInputChange(input);
                },
                title: spec.title == null ? this._options.text.fileInputTitle : spec.title
            });

            this._disposeSupport.addDisposer(function() {
                button.dispose();
            });

            self._buttons.push(button);

            return button;
        },

        _createUploadHandler: function(additionalOptions, namespace) {
            var self = this,
                lastOnProgress = {},
                options = {
                    debug: this._options.debug,
                    maxConnections: this._options.maxConnections,
                    cors: this._options.cors,
                    paramsStore: this._paramsStore,
                    endpointStore: this._endpointStore,
                    chunking: this._options.chunking,
                    resume: this._options.resume,
                    blobs: this._options.blobs,
                    log: qq.bind(self.log, self),
                    preventRetryParam: this._options.retry.preventRetryResponseProperty,
                    onProgress: function(id, name, loaded, total) {
                        if (loaded < 0 || total < 0) {
                            return;
                        }

                        if (lastOnProgress[id]) {
                            if (lastOnProgress[id].loaded !== loaded || lastOnProgress[id].total !== total) {
                                self._onProgress(id, name, loaded, total);
                                self._options.callbacks.onProgress(id, name, loaded, total);
                            }
                        }
                        else {
                            self._onProgress(id, name, loaded, total);
                            self._options.callbacks.onProgress(id, name, loaded, total);
                        }

                        lastOnProgress[id] = {loaded: loaded, total: total};

                    },
                    onComplete: function(id, name, result, xhr) {
                        delete lastOnProgress[id];

                        var status = self.getUploads({id: id}).status,
                            retVal;

                        // This is to deal with some observed cases where the XHR readyStateChange handler is
                        // invoked by the browser multiple times for the same XHR instance with the same state
                        // readyState value.  Higher level: don't invoke complete-related code if we've already
                        // done this.
                        if (status === qq.status.UPLOAD_SUCCESSFUL || status === qq.status.UPLOAD_FAILED) {
                            return;
                        }

                        retVal = self._onComplete(id, name, result, xhr);

                        // If the internal `_onComplete` handler returns a promise, don't invoke the `onComplete` callback
                        // until the promise has been fulfilled.
                        if (retVal instanceof  qq.Promise) {
                            retVal.done(function() {
                                self._options.callbacks.onComplete(id, name, result, xhr);
                            });
                        }
                        else {
                            self._options.callbacks.onComplete(id, name, result, xhr);
                        }
                    },
                    onCancel: function(id, name, cancelFinalizationEffort) {
                        var promise = new qq.Promise();

                        self._handleCheckedCallback({
                            name: "onCancel",
                            callback: qq.bind(self._options.callbacks.onCancel, self, id, name),
                            onFailure: promise.failure,
                            onSuccess: function() {
                                cancelFinalizationEffort.then(function() {
                                    self._onCancel(id, name);
                                });

                                promise.success();
                            },
                            identifier: id
                        });

                        return promise;
                    },
                    onUploadPrep: qq.bind(this._onUploadPrep, this),
                    onUpload: function(id, name) {
                        self._onUpload(id, name);
                        self._options.callbacks.onUpload(id, name);
                    },
                    onUploadChunk: function(id, name, chunkData) {
                        self._onUploadChunk(id, chunkData);
                        self._options.callbacks.onUploadChunk(id, name, chunkData);
                    },
                    onUploadChunkSuccess: function(id, chunkData, result, xhr) {
                        self._options.callbacks.onUploadChunkSuccess.apply(self, arguments);
                    },
                    onResume: function(id, name, chunkData) {
                        return self._options.callbacks.onResume(id, name, chunkData);
                    },
                    onAutoRetry: function(id, name, responseJSON, xhr) {
                        return self._onAutoRetry.apply(self, arguments);
                    },
                    onUuidChanged: function(id, newUuid) {
                        self.log("Server requested UUID change from '" + self.getUuid(id) + "' to '" + newUuid + "'");
                        self.setUuid(id, newUuid);
                    },
                    getName: qq.bind(self.getName, self),
                    getUuid: qq.bind(self.getUuid, self),
                    getSize: qq.bind(self.getSize, self),
                    setSize: qq.bind(self._setSize, self),
                    getDataByUuid: function(uuid) {
                        return self.getUploads({uuid: uuid});
                    },
                    isQueued: function(id) {
                        var status = self.getUploads({id: id}).status;
                        return status === qq.status.QUEUED ||
                            status === qq.status.SUBMITTED ||
                            status === qq.status.UPLOAD_RETRYING ||
                            status === qq.status.PAUSED;
                    },
                    getIdsInProxyGroup: self._uploadData.getIdsInProxyGroup,
                    getIdsInBatch: self._uploadData.getIdsInBatch
                };

            qq.each(this._options.request, function(prop, val) {
                options[prop] = val;
            });

            options.customHeaders = this._customHeadersStore;

            if (additionalOptions) {
                qq.each(additionalOptions, function(key, val) {
                    options[key] = val;
                });
            }

            return new qq.UploadHandlerController(options, namespace);
        },

        _fileOrBlobRejected: function(id) {
            this._netUploadedOrQueued--;
            this._uploadData.setStatus(id, qq.status.REJECTED);
        },

        _formatSize: function(bytes) {
            var i = -1;
            do {
                bytes = bytes / 1000;
                i++;
            } while (bytes > 999);

            return Math.max(bytes, 0.1).toFixed(1) + this._options.text.sizeSymbols[i];
        },

        // Creates an internal object that tracks various properties of each extra button,
        // and then actually creates the extra button.
        _generateExtraButtonSpecs: function() {
            var self = this;

            this._extraButtonSpecs = {};

            qq.each(this._options.extraButtons, function(idx, extraButtonOptionEntry) {
                var multiple = extraButtonOptionEntry.multiple,
                    validation = qq.extend({}, self._options.validation, true),
                    extraButtonSpec = qq.extend({}, extraButtonOptionEntry);

                if (multiple === undefined) {
                    multiple = self._options.multiple;
                }

                if (extraButtonSpec.validation) {
                    qq.extend(validation, extraButtonOptionEntry.validation, true);
                }

                qq.extend(extraButtonSpec, {
                    multiple: multiple,
                    validation: validation
                }, true);

                self._initExtraButton(extraButtonSpec);
            });
        },

        _getButton: function(buttonId) {
            var extraButtonsSpec = this._extraButtonSpecs[buttonId];

            if (extraButtonsSpec) {
                return extraButtonsSpec.element;
            }
            else if (buttonId === this._defaultButtonId) {
                return this._options.button;
            }
        },

        /**
         * Gets the internally used tracking ID for a button.
         *
         * @param buttonOrFileInputOrFile `File`, `<input type="file">`, or a button container element
         * @returns {*} The button's ID, or undefined if no ID is recoverable
         * @private
         */
        _getButtonId: function(buttonOrFileInputOrFile) {
            var inputs, fileInput,
                fileBlobOrInput = buttonOrFileInputOrFile;

            // We want the reference file/blob here if this is a proxy (a file that will be generated on-demand later)
            if (fileBlobOrInput instanceof qq.BlobProxy) {
                fileBlobOrInput = fileBlobOrInput.referenceBlob;
            }

            // If the item is a `Blob` it will never be associated with a button or drop zone.
            if (fileBlobOrInput && !qq.isBlob(fileBlobOrInput)) {
                if (qq.isFile(fileBlobOrInput)) {
                    return fileBlobOrInput.qqButtonId;
                }
                else if (fileBlobOrInput.tagName.toLowerCase() === "input" &&
                    fileBlobOrInput.type.toLowerCase() === "file") {

                    return fileBlobOrInput.getAttribute(qq.UploadButton.BUTTON_ID_ATTR_NAME);
                }

                inputs = fileBlobOrInput.getElementsByTagName("input");

                qq.each(inputs, function(idx, input) {
                    if (input.getAttribute("type") === "file") {
                        fileInput = input;
                        return false;
                    }
                });

                if (fileInput) {
                    return fileInput.getAttribute(qq.UploadButton.BUTTON_ID_ATTR_NAME);
                }
            }
        },

        _getNotFinished: function() {
            return this._uploadData.retrieve({
                status: [
                    qq.status.UPLOADING,
                    qq.status.UPLOAD_RETRYING,
                    qq.status.QUEUED,
                    qq.status.SUBMITTING,
                    qq.status.SUBMITTED,
                    qq.status.PAUSED
                ]
            }).length;
        },

        // Get the validation options for this button.  Could be the default validation option
        // or a specific one assigned to this particular button.
        _getValidationBase: function(buttonId) {
            var extraButtonSpec = this._extraButtonSpecs[buttonId];

            return extraButtonSpec ? extraButtonSpec.validation : this._options.validation;
        },

        _getValidationDescriptor: function(fileWrapper) {
            if (fileWrapper.file instanceof qq.BlobProxy) {
                return {
                    name: qq.getFilename(fileWrapper.file.referenceBlob),
                    size: fileWrapper.file.referenceBlob.size
                };
            }

            return {
                name: this.getUploads({id: fileWrapper.id}).name,
                size: this.getUploads({id: fileWrapper.id}).size
            };
        },

        _getValidationDescriptors: function(fileWrappers) {
            var self = this,
                fileDescriptors = [];

            qq.each(fileWrappers, function(idx, fileWrapper) {
                fileDescriptors.push(self._getValidationDescriptor(fileWrapper));
            });

            return fileDescriptors;
        },

        // Allows camera access on either the default or an extra button for iOS devices.
        _handleCameraAccess: function() {
            if (this._options.camera.ios && qq.ios()) {
                var acceptIosCamera = "image/*;capture=camera",
                    button = this._options.camera.button,
                    buttonId = button ? this._getButtonId(button) : this._defaultButtonId,
                    optionRoot = this._options;

                // If we are not targeting the default button, it is an "extra" button
                if (buttonId && buttonId !== this._defaultButtonId) {
                    optionRoot = this._extraButtonSpecs[buttonId];
                }

                // Camera access won't work in iOS if the `multiple` attribute is present on the file input
                optionRoot.multiple = false;

                // update the options
                if (optionRoot.validation.acceptFiles === null) {
                    optionRoot.validation.acceptFiles = acceptIosCamera;
                }
                else {
                    optionRoot.validation.acceptFiles += "," + acceptIosCamera;
                }

                // update the already-created button
                qq.each(this._buttons, function(idx, button) {
                    if (button.getButtonId() === buttonId) {
                        button.setMultiple(optionRoot.multiple);
                        button.setAcceptFiles(optionRoot.acceptFiles);

                        return false;
                    }
                });
            }
        },

        _handleCheckedCallback: function(details) {
            var self = this,
                callbackRetVal = details.callback();

            if (qq.isGenericPromise(callbackRetVal)) {
                this.log(details.name + " - waiting for " + details.name + " promise to be fulfilled for " + details.identifier);
                return callbackRetVal.then(
                    function(successParam) {
                        self.log(details.name + " promise success for " + details.identifier);
                        details.onSuccess(successParam);
                    },
                    function() {
                        if (details.onFailure) {
                            self.log(details.name + " promise failure for " + details.identifier);
                            details.onFailure();
                        }
                        else {
                            self.log(details.name + " promise failure for " + details.identifier);
                        }
                    });
            }

            if (callbackRetVal !== false) {
                details.onSuccess(callbackRetVal);
            }
            else {
                if (details.onFailure) {
                    this.log(details.name + " - return value was 'false' for " + details.identifier + ".  Invoking failure callback.");
                    details.onFailure();
                }
                else {
                    this.log(details.name + " - return value was 'false' for " + details.identifier + ".  Will not proceed.");
                }
            }

            return callbackRetVal;
        },

        // Updates internal state when a new file has been received, and adds it along with its ID to a passed array.
        _handleNewFile: function(file, batchId, newFileWrapperList) {
            var self = this,
                uuid = qq.getUniqueId(),
                size = -1,
                name = qq.getFilename(file),
                actualFile = file.blob || file,
                handler = this._customNewFileHandler ?
                    this._customNewFileHandler :
                    qq.bind(self._handleNewFileGeneric, self);

            if (!qq.isInput(actualFile) && actualFile.size >= 0) {
                size = actualFile.size;
            }

            handler(actualFile, name, uuid, size, newFileWrapperList, batchId, this._options.request.uuidName, {
                uploadData: self._uploadData,
                paramsStore: self._paramsStore,
                addFileToHandler: function(id, file) {
                    self._handler.add(id, file);
                    self._netUploadedOrQueued++;
                    self._trackButton(id);
                }
            });
        },

        _handleNewFileGeneric: function(file, name, uuid, size, fileList, batchId) {
            var id = this._uploadData.addFile({uuid: uuid, name: name, size: size, batchId: batchId});

            this._handler.add(id, file);
            this._trackButton(id);

            this._netUploadedOrQueued++;

            fileList.push({id: id, file: file});
        },

        _handlePasteSuccess: function(blob, extSuppliedName) {
            var extension = blob.type.split("/")[1],
                name = extSuppliedName;

            /*jshint eqeqeq: true, eqnull: true*/
            if (name == null) {
                name = this._options.paste.defaultName;
            }

            name += "." + extension;

            this.addFiles({
                name: name,
                blob: blob
            });
        },

        // Creates an extra button element
        _initExtraButton: function(spec) {
            var button = this._createUploadButton({
                accept: spec.validation.acceptFiles,
                allowedExtensions: spec.validation.allowedExtensions,
                element: spec.element,
                folders: spec.folders,
                multiple: spec.multiple,
                title: spec.fileInputTitle
            });

            this._extraButtonSpecs[button.getButtonId()] = spec;
        },

        _initFormSupportAndParams: function() {
            this._formSupport = qq.FormSupport && new qq.FormSupport(
                this._options.form, qq.bind(this.uploadStoredFiles, this), qq.bind(this.log, this)
            );

            if (this._formSupport && this._formSupport.attachedToForm) {
                this._paramsStore = this._createStore(
                    this._options.request.params,  this._formSupport.getFormInputsAsObject
                );

                this._options.autoUpload = this._formSupport.newAutoUpload;
                if (this._formSupport.newEndpoint) {
                    this._options.request.endpoint = this._formSupport.newEndpoint;
                }
            }
            else {
                this._paramsStore = this._createStore(this._options.request.params);
            }
        },

        _isDeletePossible: function() {
            if (!qq.DeleteFileAjaxRequester || !this._options.deleteFile.enabled) {
                return false;
            }

            if (this._options.cors.expected) {
                if (qq.supportedFeatures.deleteFileCorsXhr) {
                    return true;
                }

                if (qq.supportedFeatures.deleteFileCorsXdr && this._options.cors.allowXdr) {
                    return true;
                }

                return false;
            }

            return true;
        },

        _isAllowedExtension: function(allowed, fileName) {
            var valid = false;

            if (!allowed.length) {
                return true;
            }

            qq.each(allowed, function(idx, allowedExt) {
                /**
                 * If an argument is not a string, ignore it.  Added when a possible issue with MooTools hijacking the
                 * `allowedExtensions` array was discovered.  See case #735 in the issue tracker for more details.
                 */
                if (qq.isString(allowedExt)) {
                    /*jshint eqeqeq: true, eqnull: true*/
                    var extRegex = new RegExp("\\." + allowedExt + "$", "i");

                    if (fileName.match(extRegex) != null) {
                        valid = true;
                        return false;
                    }
                }
            });

            return valid;
        },

        /**
         * Constructs and returns a message that describes an item/file error.  Also calls `onError` callback.
         *
         * @param code REQUIRED - a code that corresponds to a stock message describing this type of error
         * @param maybeNameOrNames names of the items that have failed, if applicable
         * @param item `File`, `Blob`, or `<input type="file">`
         * @private
         */
        _itemError: function(code, maybeNameOrNames, item) {
            var message = this._options.messages[code],
                allowedExtensions = [],
                names = [].concat(maybeNameOrNames),
                name = names[0],
                buttonId = this._getButtonId(item),
                validationBase = this._getValidationBase(buttonId),
                extensionsForMessage, placeholderMatch;

            function r(name, replacement) { message = message.replace(name, replacement); }

            qq.each(validationBase.allowedExtensions, function(idx, allowedExtension) {
                /**
                 * If an argument is not a string, ignore it.  Added when a possible issue with MooTools hijacking the
                 * `allowedExtensions` array was discovered.  See case #735 in the issue tracker for more details.
                 */
                if (qq.isString(allowedExtension)) {
                    allowedExtensions.push(allowedExtension);
                }
            });

            extensionsForMessage = allowedExtensions.join(", ").toLowerCase();

            r("{file}", this._options.formatFileName(name));
            r("{extensions}", extensionsForMessage);
            r("{sizeLimit}", this._formatSize(validationBase.sizeLimit));
            r("{minSizeLimit}", this._formatSize(validationBase.minSizeLimit));

            placeholderMatch = message.match(/(\{\w+\})/g);
            if (placeholderMatch !== null) {
                qq.each(placeholderMatch, function(idx, placeholder) {
                    r(placeholder, names[idx]);
                });
            }

            this._options.callbacks.onError(null, name, message, undefined);

            return message;
        },

        /**
         * Conditionally orders a manual retry of a failed upload.
         *
         * @param id File ID of the failed upload
         * @param callback Optional callback to invoke if a retry is prudent.
         * In lieu of asking the upload handler to retry.
         * @returns {boolean} true if a manual retry will occur
         * @private
         */
        _manualRetry: function(id, callback) {
            if (this._onBeforeManualRetry(id)) {
                this._netUploadedOrQueued++;
                this._uploadData.setStatus(id, qq.status.UPLOAD_RETRYING);

                if (callback) {
                    callback(id);
                }
                else {
                    this._handler.retry(id);
                }

                return true;
            }
        },

        _maybeAllComplete: function(id, status) {
            var self = this,
                notFinished = this._getNotFinished();

            if (status === qq.status.UPLOAD_SUCCESSFUL) {
                this._succeededSinceLastAllComplete.push(id);
            }
            else if (status === qq.status.UPLOAD_FAILED) {
                this._failedSinceLastAllComplete.push(id);
            }

            if (notFinished === 0 &&
                (this._succeededSinceLastAllComplete.length || this._failedSinceLastAllComplete.length)) {
                // Attempt to ensure onAllComplete is not invoked before other callbacks, such as onCancel & onComplete
                setTimeout(function() {
                    self._onAllComplete(self._succeededSinceLastAllComplete, self._failedSinceLastAllComplete);
                }, 0);
            }
        },

        _maybeHandleIos8SafariWorkaround: function() {
            var self = this;

            if (this._options.workarounds.ios8SafariUploads && qq.ios800() && qq.iosSafari()) {
                setTimeout(function() {
                    window.alert(self._options.messages.unsupportedBrowserIos8Safari);
                }, 0);
                throw new qq.Error(this._options.messages.unsupportedBrowserIos8Safari);
            }
        },

        _maybeParseAndSendUploadError: function(id, name, response, xhr) {
            // Assuming no one will actually set the response code to something other than 200
            // and still set 'success' to true...
            if (!response.success) {
                if (xhr && xhr.status !== 200 && !response.error) {
                    this._options.callbacks.onError(id, name, "XHR returned response code " + xhr.status, xhr);
                }
                else {
                    var errorReason = response.error ? response.error : this._options.text.defaultResponseError;
                    this._options.callbacks.onError(id, name, errorReason, xhr);
                }
            }
        },

        _maybeProcessNextItemAfterOnValidateCallback: function(validItem, items, index, params, endpoint) {
            var self = this;

            if (items.length > index) {
                if (validItem || !this._options.validation.stopOnFirstInvalidFile) {
                    //use setTimeout to prevent a stack overflow with a large number of files in the batch & non-promissory callbacks
                    setTimeout(function() {
                        var validationDescriptor = self._getValidationDescriptor(items[index]),
                            buttonId = self._getButtonId(items[index].file),
                            button = self._getButton(buttonId);

                        self._handleCheckedCallback({
                            name: "onValidate",
                            callback: qq.bind(self._options.callbacks.onValidate, self, validationDescriptor, button),
                            onSuccess: qq.bind(self._onValidateCallbackSuccess, self, items, index, params, endpoint),
                            onFailure: qq.bind(self._onValidateCallbackFailure, self, items, index, params, endpoint),
                            identifier: "Item '" + validationDescriptor.name + "', size: " + validationDescriptor.size
                        });
                    }, 0);
                }
                else if (!validItem) {
                    for (; index < items.length; index++) {
                        self._fileOrBlobRejected(items[index].id);
                    }
                }
            }
        },

        _onAllComplete: function(successful, failed) {
            this._totalProgress && this._totalProgress.onAllComplete(successful, failed, this._preventRetries);

            this._options.callbacks.onAllComplete(qq.extend([], successful), qq.extend([], failed));

            this._succeededSinceLastAllComplete = [];
            this._failedSinceLastAllComplete = [];
        },

        /**
         * Attempt to automatically retry a failed upload.
         *
         * @param id The file ID of the failed upload
         * @param name The name of the file associated with the failed upload
         * @param responseJSON Response from the server, parsed into a javascript object
         * @param xhr Ajax transport used to send the failed request
         * @param callback Optional callback to be invoked if a retry is prudent.
         * Invoked in lieu of asking the upload handler to retry.
         * @returns {boolean} true if an auto-retry will occur
         * @private
         */
        _onAutoRetry: function(id, name, responseJSON, xhr, callback) {
            var self = this;

            self._preventRetries[id] = responseJSON[self._options.retry.preventRetryResponseProperty];

            if (self._shouldAutoRetry(id, name, responseJSON)) {
                self._maybeParseAndSendUploadError.apply(self, arguments);
                self._options.callbacks.onAutoRetry(id, name, self._autoRetries[id]);
                self._onBeforeAutoRetry(id, name);

                self._retryTimeouts[id] = setTimeout(function() {
                    self.log("Retrying " + name + "...");
                    self._uploadData.setStatus(id, qq.status.UPLOAD_RETRYING);

                    if (callback) {
                        callback(id);
                    }
                    else {
                        self._handler.retry(id);
                    }
                }, self._options.retry.autoAttemptDelay * 1000);

                return true;
            }
        },

        _onBeforeAutoRetry: function(id, name) {
            this.log("Waiting " + this._options.retry.autoAttemptDelay + " seconds before retrying " + name + "...");
        },

        //return false if we should not attempt the requested retry
        _onBeforeManualRetry: function(id) {
            var itemLimit = this._currentItemLimit,
                fileName;

            if (this._preventRetries[id]) {
                this.log("Retries are forbidden for id " + id, "warn");
                return false;
            }
            else if (this._handler.isValid(id)) {
                fileName = this.getName(id);

                if (this._options.callbacks.onManualRetry(id, fileName) === false) {
                    return false;
                }

                if (itemLimit > 0 && this._netUploadedOrQueued + 1 > itemLimit) {
                    this._itemError("retryFailTooManyItems");
                    return false;
                }

                this.log("Retrying upload for '" + fileName + "' (id: " + id + ")...");
                return true;
            }
            else {
                this.log("'" + id + "' is not a valid file ID", "error");
                return false;
            }
        },

        _onCancel: function(id, name) {
            this._netUploadedOrQueued--;

            clearTimeout(this._retryTimeouts[id]);

            var storedItemIndex = qq.indexOf(this._storedIds, id);
            if (!this._options.autoUpload && storedItemIndex >= 0) {
                this._storedIds.splice(storedItemIndex, 1);
            }

            this._uploadData.setStatus(id, qq.status.CANCELED);
        },

        _onComplete: function(id, name, result, xhr) {
            if (!result.success) {
                this._netUploadedOrQueued--;
                this._uploadData.setStatus(id, qq.status.UPLOAD_FAILED);

                if (result[this._options.retry.preventRetryResponseProperty] === true) {
                    this._preventRetries[id] = true;
                }
            }
            else {
                if (result.thumbnailUrl) {
                    this._thumbnailUrls[id] = result.thumbnailUrl;
                }

                this._netUploaded++;
                this._uploadData.setStatus(id, qq.status.UPLOAD_SUCCESSFUL);
            }

            this._maybeParseAndSendUploadError(id, name, result, xhr);

            return result.success ? true : false;
        },

        _onDelete: function(id) {
            this._uploadData.setStatus(id, qq.status.DELETING);
        },

        _onDeleteComplete: function(id, xhrOrXdr, isError) {
            var name = this.getName(id);

            if (isError) {
                this._uploadData.setStatus(id, qq.status.DELETE_FAILED);
                this.log("Delete request for '" + name + "' has failed.", "error");

                // For error reporting, we only have access to the response status if this is not
                // an `XDomainRequest`.
                if (xhrOrXdr.withCredentials === undefined) {
                    this._options.callbacks.onError(id, name, "Delete request failed", xhrOrXdr);
                }
                else {
                    this._options.callbacks.onError(id, name, "Delete request failed with response code " + xhrOrXdr.status, xhrOrXdr);
                }
            }
            else {
                this._netUploadedOrQueued--;
                this._netUploaded--;
                this._handler.expunge(id);
                this._uploadData.setStatus(id, qq.status.DELETED);
                this.log("Delete request for '" + name + "' has succeeded.");
            }
        },

        _onInputChange: function(input) {
            var fileIndex;

            if (qq.supportedFeatures.ajaxUploading) {
                for (fileIndex = 0; fileIndex < input.files.length; fileIndex++) {
                    this._annotateWithButtonId(input.files[fileIndex], input);
                }

                this.addFiles(input.files);
            }
            // Android 2.3.x will fire `onchange` even if no file has been selected
            else if (input.value.length > 0) {
                this.addFiles(input);
            }

            qq.each(this._buttons, function(idx, button) {
                button.reset();
            });
        },

        _onProgress: function(id, name, loaded, total) {
            this._totalProgress && this._totalProgress.onIndividualProgress(id, loaded, total);
        },

        _onSubmit: function(id, name) {
            //nothing to do yet in core uploader
        },

        _onSubmitCallbackSuccess: function(id, name) {
            this._onSubmit.apply(this, arguments);
            this._uploadData.setStatus(id, qq.status.SUBMITTED);
            this._onSubmitted.apply(this, arguments);

            if (this._options.autoUpload) {
                this._options.callbacks.onSubmitted.apply(this, arguments);
                this._uploadFile(id);
            }
            else {
                this._storeForLater(id);
                this._options.callbacks.onSubmitted.apply(this, arguments);
            }
        },

        _onSubmitDelete: function(id, onSuccessCallback, additionalMandatedParams) {
            var uuid = this.getUuid(id),
                adjustedOnSuccessCallback;

            if (onSuccessCallback) {
                adjustedOnSuccessCallback = qq.bind(onSuccessCallback, this, id, uuid, additionalMandatedParams);
            }

            if (this._isDeletePossible()) {
                this._handleCheckedCallback({
                    name: "onSubmitDelete",
                    callback: qq.bind(this._options.callbacks.onSubmitDelete, this, id),
                    onSuccess: adjustedOnSuccessCallback ||
                        qq.bind(this._deleteHandler.sendDelete, this, id, uuid, additionalMandatedParams),
                    identifier: id
                });
                return true;
            }
            else {
                this.log("Delete request ignored for ID " + id + ", delete feature is disabled or request not possible " +
                    "due to CORS on a user agent that does not support pre-flighting.", "warn");
                return false;
            }
        },

        _onSubmitted: function(id) {
            //nothing to do in the base uploader
        },

        _onTotalProgress: function(loaded, total) {
            this._options.callbacks.onTotalProgress(loaded, total);
        },

        _onUploadPrep: function(id) {
            // nothing to do in the core uploader for now
        },

        _onUpload: function(id, name) {
            this._uploadData.setStatus(id, qq.status.UPLOADING);
        },

        _onUploadChunk: function(id, chunkData) {
            //nothing to do in the base uploader
        },

        _onUploadStatusChange: function(id, oldStatus, newStatus) {
            // Make sure a "queued" retry attempt is canceled if the upload has been paused
            if (newStatus === qq.status.PAUSED) {
                clearTimeout(this._retryTimeouts[id]);
            }
        },

        _onValidateBatchCallbackFailure: function(fileWrappers) {
            var self = this;

            qq.each(fileWrappers, function(idx, fileWrapper) {
                self._fileOrBlobRejected(fileWrapper.id);
            });
        },

        _onValidateBatchCallbackSuccess: function(validationDescriptors, items, params, endpoint, button) {
            var errorMessage,
                itemLimit = this._currentItemLimit,
                proposedNetFilesUploadedOrQueued = this._netUploadedOrQueued;

            if (itemLimit === 0 || proposedNetFilesUploadedOrQueued <= itemLimit) {
                if (items.length > 0) {
                    this._handleCheckedCallback({
                        name: "onValidate",
                        callback: qq.bind(this._options.callbacks.onValidate, this, validationDescriptors[0], button),
                        onSuccess: qq.bind(this._onValidateCallbackSuccess, this, items, 0, params, endpoint),
                        onFailure: qq.bind(this._onValidateCallbackFailure, this, items, 0, params, endpoint),
                        identifier: "Item '" + items[0].file.name + "', size: " + items[0].file.size
                    });
                }
                else {
                    this._itemError("noFilesError");
                }
            }
            else {
                this._onValidateBatchCallbackFailure(items);
                errorMessage = this._options.messages.tooManyItemsError
                    .replace(/\{netItems\}/g, proposedNetFilesUploadedOrQueued)
                    .replace(/\{itemLimit\}/g, itemLimit);
                this._batchError(errorMessage);
            }
        },

        _onValidateCallbackFailure: function(items, index, params, endpoint) {
            var nextIndex = index + 1;

            this._fileOrBlobRejected(items[index].id, items[index].file.name);

            this._maybeProcessNextItemAfterOnValidateCallback(false, items, nextIndex, params, endpoint);
        },

        _onValidateCallbackSuccess: function(items, index, params, endpoint) {
            var self = this,
                nextIndex = index + 1,
                validationDescriptor = this._getValidationDescriptor(items[index]);

            this._validateFileOrBlobData(items[index], validationDescriptor)
                .then(
                function() {
                    self._upload(items[index].id, params, endpoint);
                    self._maybeProcessNextItemAfterOnValidateCallback(true, items, nextIndex, params, endpoint);
                },
                function() {
                    self._maybeProcessNextItemAfterOnValidateCallback(false, items, nextIndex, params, endpoint);
                }
            );
        },

        _prepareItemsForUpload: function(items, params, endpoint) {
            if (items.length === 0) {
                this._itemError("noFilesError");
                return;
            }

            var validationDescriptors = this._getValidationDescriptors(items),
                buttonId = this._getButtonId(items[0].file),
                button = this._getButton(buttonId);

            this._handleCheckedCallback({
                name: "onValidateBatch",
                callback: qq.bind(this._options.callbacks.onValidateBatch, this, validationDescriptors, button),
                onSuccess: qq.bind(this._onValidateBatchCallbackSuccess, this, validationDescriptors, items, params, endpoint, button),
                onFailure: qq.bind(this._onValidateBatchCallbackFailure, this, items),
                identifier: "batch validation"
            });
        },

        _preventLeaveInProgress: function() {
            var self = this;

            this._disposeSupport.attach(window, "beforeunload", function(e) {
                if (self.getInProgress()) {
                    e = e || window.event;
                    // for ie, ff
                    e.returnValue = self._options.messages.onLeave;
                    // for webkit
                    return self._options.messages.onLeave;
                }
            });
        },

        // Attempts to refresh session data only if the `qq.Session` module exists
        // and a session endpoint has been specified.  The `onSessionRequestComplete`
        // callback will be invoked once the refresh is complete.
        _refreshSessionData: function() {
            var self = this,
                options = this._options.session;

            /* jshint eqnull:true */
            if (qq.Session && this._options.session.endpoint != null) {
                if (!this._session) {
                    qq.extend(options, this._options.cors);

                    options.log = qq.bind(this.log, this);
                    options.addFileRecord = qq.bind(this._addCannedFile, this);

                    this._session = new qq.Session(options);
                }

                setTimeout(function() {
                    self._session.refresh().then(function(response, xhrOrXdr) {
                        self._sessionRequestComplete();
                        self._options.callbacks.onSessionRequestComplete(response, true, xhrOrXdr);

                    }, function(response, xhrOrXdr) {

                        self._options.callbacks.onSessionRequestComplete(response, false, xhrOrXdr);
                    });
                }, 0);
            }
        },

        _sessionRequestComplete: function() {},

        _setSize: function(id, newSize) {
            this._uploadData.updateSize(id, newSize);
            this._totalProgress && this._totalProgress.onNewSize(id);
        },

        _shouldAutoRetry: function(id, name, responseJSON) {
            var uploadData = this._uploadData.retrieve({id: id});

            /*jshint laxbreak: true */
            if (!this._preventRetries[id]
                && this._options.retry.enableAuto
                && uploadData.status !== qq.status.PAUSED) {

                if (this._autoRetries[id] === undefined) {
                    this._autoRetries[id] = 0;
                }

                if (this._autoRetries[id] < this._options.retry.maxAutoAttempts) {
                    this._autoRetries[id] += 1;
                    return true;
                }
            }

            return false;
        },

        _storeForLater: function(id) {
            this._storedIds.push(id);
        },

        // Maps a file with the button that was used to select it.
        _trackButton: function(id) {
            var buttonId;

            if (qq.supportedFeatures.ajaxUploading) {
                buttonId = this._handler.getFile(id).qqButtonId;
            }
            else {
                buttonId = this._getButtonId(this._handler.getInput(id));
            }

            if (buttonId) {
                this._buttonIdsForFileIds[id] = buttonId;
            }
        },

        _updateFormSupportAndParams: function(formElementOrId) {
            this._options.form.element = formElementOrId;

            this._formSupport = qq.FormSupport && new qq.FormSupport(
                    this._options.form, qq.bind(this.uploadStoredFiles, this), qq.bind(this.log, this)
                );

            if (this._formSupport && this._formSupport.attachedToForm) {
                this._paramsStore.addReadOnly(null, this._formSupport.getFormInputsAsObject);

                this._options.autoUpload = this._formSupport.newAutoUpload;
                if (this._formSupport.newEndpoint) {
                    this.setEndpoint(this._formSupport.newEndpoint);
                }
            }
        },

        _upload: function(id, params, endpoint) {
            var name = this.getName(id);

            if (params) {
                this.setParams(params, id);
            }

            if (endpoint) {
                this.setEndpoint(endpoint, id);
            }

            this._handleCheckedCallback({
                name: "onSubmit",
                callback: qq.bind(this._options.callbacks.onSubmit, this, id, name),
                onSuccess: qq.bind(this._onSubmitCallbackSuccess, this, id, name),
                onFailure: qq.bind(this._fileOrBlobRejected, this, id, name),
                identifier: id
            });
        },

        _uploadFile: function(id) {
            if (!this._handler.upload(id)) {
                this._uploadData.setStatus(id, qq.status.QUEUED);
            }
        },

        _uploadStoredFiles: function() {
            var idToUpload, stillSubmitting,
                self = this;

            while (this._storedIds.length) {
                idToUpload = this._storedIds.shift();
                this._uploadFile(idToUpload);
            }

            // If we are still waiting for some files to clear validation, attempt to upload these again in a bit
            stillSubmitting = this.getUploads({status: qq.status.SUBMITTING}).length;
            if (stillSubmitting) {
                qq.log("Still waiting for " + stillSubmitting + " files to clear submit queue. Will re-parse stored IDs array shortly.");
                setTimeout(function() {
                    self._uploadStoredFiles();
                }, 1000);
            }
        },

        /**
         * Performs some internal validation checks on an item, defined in the `validation` option.
         *
         * @param fileWrapper Wrapper containing a `file` along with an `id`
         * @param validationDescriptor Normalized information about the item (`size`, `name`).
         * @returns qq.Promise with appropriate callbacks invoked depending on the validity of the file
         * @private
         */
        _validateFileOrBlobData: function(fileWrapper, validationDescriptor) {
            var self = this,
                file = (function() {
                    if (fileWrapper.file instanceof qq.BlobProxy) {
                        return fileWrapper.file.referenceBlob;
                    }
                    return fileWrapper.file;
                }()),
                name = validationDescriptor.name,
                size = validationDescriptor.size,
                buttonId = this._getButtonId(fileWrapper.file),
                validationBase = this._getValidationBase(buttonId),
                validityChecker = new qq.Promise();

            validityChecker.then(
                function() {},
                function() {
                    self._fileOrBlobRejected(fileWrapper.id, name);
                });

            if (qq.isFileOrInput(file) && !this._isAllowedExtension(validationBase.allowedExtensions, name)) {
                this._itemError("typeError", name, file);
                return validityChecker.failure();
            }

            if (size === 0) {
                this._itemError("emptyError", name, file);
                return validityChecker.failure();
            }

            if (size > 0 && validationBase.sizeLimit && size > validationBase.sizeLimit) {
                this._itemError("sizeError", name, file);
                return validityChecker.failure();
            }

            if (size > 0 && size < validationBase.minSizeLimit) {
                this._itemError("minSizeError", name, file);
                return validityChecker.failure();
            }

            if (qq.ImageValidation && qq.supportedFeatures.imagePreviews && qq.isFile(file)) {
                new qq.ImageValidation(file, qq.bind(self.log, self)).validate(validationBase.image).then(
                    validityChecker.success,
                    function(errorCode) {
                        self._itemError(errorCode + "ImageError", name, file);
                        validityChecker.failure();
                    }
                );
            }
            else {
                validityChecker.success();
            }

            return validityChecker;
        },

        _wrapCallbacks: function() {
            var self, safeCallback, prop;

            self = this;

            safeCallback = function(name, callback, args) {
                var errorMsg;

                try {
                    return callback.apply(self, args);
                }
                catch (exception) {
                    errorMsg = exception.message || exception.toString();
                    self.log("Caught exception in '" + name + "' callback - " + errorMsg, "error");
                }
            };

            /* jshint forin: false, loopfunc: true */
            for (prop in this._options.callbacks) {
                (function() {
                    var callbackName, callbackFunc;
                    callbackName = prop;
                    callbackFunc = self._options.callbacks[callbackName];
                    self._options.callbacks[callbackName] = function() {
                        return safeCallback(callbackName, callbackFunc, arguments);
                    };
                }());
            }
        }
    };
}());

/*globals qq*/
(function() {
    "use strict";

    qq.FineUploaderBasic = function(o) {
        var self = this;

        // These options define FineUploaderBasic mode.
        this._options = {
            debug: false,
            button: null,
            multiple: true,
            maxConnections: 3,
            disableCancelForFormUploads: false,
            autoUpload: true,

            request: {
                customHeaders: {},
                endpoint: "/server/upload",
                filenameParam: "qqfilename",
                forceMultipart: true,
                inputName: "qqfile",
                method: "POST",
                params: {},
                paramsInBody: true,
                totalFileSizeName: "qqtotalfilesize",
                uuidName: "qquuid"
            },

            validation: {
                allowedExtensions: [],
                sizeLimit: 0,
                minSizeLimit: 0,
                itemLimit: 0,
                stopOnFirstInvalidFile: true,
                acceptFiles: null,
                image: {
                    maxHeight: 0,
                    maxWidth: 0,
                    minHeight: 0,
                    minWidth: 0
                }
            },

            callbacks: {
                onSubmit: function(id, name) {},
                onSubmitted: function(id, name) {},
                onComplete: function(id, name, responseJSON, maybeXhr) {},
                onAllComplete: function(successful, failed) {},
                onCancel: function(id, name) {},
                onUpload: function(id, name) {},
                onUploadChunk: function(id, name, chunkData) {},
                onUploadChunkSuccess: function(id, chunkData, responseJSON, xhr) {},
                onResume: function(id, fileName, chunkData) {},
                onProgress: function(id, name, loaded, total) {},
                onTotalProgress: function(loaded, total) {},
                onError: function(id, name, reason, maybeXhrOrXdr) {},
                onAutoRetry: function(id, name, attemptNumber) {},
                onManualRetry: function(id, name) {},
                onValidateBatch: function(fileOrBlobData) {},
                onValidate: function(fileOrBlobData) {},
                onSubmitDelete: function(id) {},
                onDelete: function(id) {},
                onDeleteComplete: function(id, xhrOrXdr, isError) {},
                onPasteReceived: function(blob) {},
                onStatusChange: function(id, oldStatus, newStatus) {},
                onSessionRequestComplete: function(response, success, xhrOrXdr) {}
            },

            messages: {
                typeError: "{file} has an invalid extension. Valid extension(s): {extensions}.",
                sizeError: "{file} is too large, maximum file size is {sizeLimit}.",
                minSizeError: "{file} is too small, minimum file size is {minSizeLimit}.",
                emptyError: "{file} is empty, please select files again without it.",
                noFilesError: "No files to upload.",
                tooManyItemsError: "Too many items ({netItems}) would be uploaded.  Item limit is {itemLimit}.",
                maxHeightImageError: "Image is too tall.",
                maxWidthImageError: "Image is too wide.",
                minHeightImageError: "Image is not tall enough.",
                minWidthImageError: "Image is not wide enough.",
                retryFailTooManyItems: "Retry failed - you have reached your file limit.",
                onLeave: "The files are being uploaded, if you leave now the upload will be canceled.",
                unsupportedBrowserIos8Safari: "Unrecoverable error - this browser does not permit file uploading of any kind due to serious bugs in iOS8 Safari.  Please use iOS8 Chrome until Apple fixes these issues."
            },

            retry: {
                enableAuto: false,
                maxAutoAttempts: 3,
                autoAttemptDelay: 5,
                preventRetryResponseProperty: "preventRetry"
            },

            classes: {
                buttonHover: "qq-upload-button-hover",
                buttonFocus: "qq-upload-button-focus"
            },

            chunking: {
                enabled: false,
                concurrent: {
                    enabled: false
                },
                mandatory: false,
                paramNames: {
                    partIndex: "qqpartindex",
                    partByteOffset: "qqpartbyteoffset",
                    chunkSize: "qqchunksize",
                    totalFileSize: "qqtotalfilesize",
                    totalParts: "qqtotalparts"
                },
                partSize: 2000000,
                // only relevant for traditional endpoints, only required when concurrent.enabled === true
                success: {
                    endpoint: null
                }
            },

            resume: {
                enabled: false,
                recordsExpireIn: 7, //days
                paramNames: {
                    resuming: "qqresume"
                }
            },

            formatFileName: function(fileOrBlobName) {
                return fileOrBlobName;
            },

            text: {
                defaultResponseError: "Upload failure reason unknown",
                fileInputTitle: "file input",
                sizeSymbols: ["kB", "MB", "GB", "TB", "PB", "EB"]
            },

            deleteFile: {
                enabled: false,
                method: "DELETE",
                endpoint: "/server/upload",
                customHeaders: {},
                params: {}
            },

            cors: {
                expected: false,
                sendCredentials: false,
                allowXdr: false
            },

            blobs: {
                defaultName: "misc_data"
            },

            paste: {
                targetElement: null,
                defaultName: "pasted_image"
            },

            camera: {
                ios: false,

                // if ios is true: button is null means target the default button, otherwise target the button specified
                button: null
            },

            // This refers to additional upload buttons to be handled by Fine Uploader.
            // Each element is an object, containing `element` as the only required
            // property.  The `element` must be a container that will ultimately
            // contain an invisible `<input type="file">` created by Fine Uploader.
            // Optional properties of each object include `multiple`, `validation`,
            // and `folders`.
            extraButtons: [],

            // Depends on the session module.  Used to query the server for an initial file list
            // during initialization and optionally after a `reset`.
            session: {
                endpoint: null,
                params: {},
                customHeaders: {},
                refreshOnReset: true
            },

            // Send parameters associated with an existing form along with the files
            form: {
                // Element ID, HTMLElement, or null
                element: "qq-form",

                // Overrides the base `autoUpload`, unless `element` is null.
                autoUpload: false,

                // true = upload files on form submission (and squelch submit event)
                interceptSubmit: true
            },

            // scale images client side, upload a new file for each scaled version
            scaling: {
                customResizer: null,

                // send the original file as well
                sendOriginal: true,

                // fox orientation for scaled images
                orient: true,

                // If null, scaled image type will match reference image type.  This value will be referred to
                // for any size record that does not specific a type.
                defaultType: null,

                defaultQuality: 80,

                failureText: "Failed to scale",

                includeExif: false,

                // metadata about each requested scaled version
                sizes: []
            },

            workarounds: {
                iosEmptyVideos: true,
                ios8SafariUploads: true,
                ios8BrowserCrash: false
            }
        };

        // Replace any default options with user defined ones
        qq.extend(this._options, o, true);

        this._buttons = [];
        this._extraButtonSpecs = {};
        this._buttonIdsForFileIds = [];

        this._wrapCallbacks();
        this._disposeSupport =  new qq.DisposeSupport();

        this._storedIds = [];
        this._autoRetries = [];
        this._retryTimeouts = [];
        this._preventRetries = [];
        this._thumbnailUrls = [];

        this._netUploadedOrQueued = 0;
        this._netUploaded = 0;
        this._uploadData = this._createUploadDataTracker();

        this._initFormSupportAndParams();

        this._customHeadersStore = this._createStore(this._options.request.customHeaders);
        this._deleteFileCustomHeadersStore = this._createStore(this._options.deleteFile.customHeaders);

        this._deleteFileParamsStore = this._createStore(this._options.deleteFile.params);

        this._endpointStore = this._createStore(this._options.request.endpoint);
        this._deleteFileEndpointStore = this._createStore(this._options.deleteFile.endpoint);

        this._handler = this._createUploadHandler();

        this._deleteHandler = qq.DeleteFileAjaxRequester && this._createDeleteHandler();

        if (this._options.button) {
            this._defaultButtonId = this._createUploadButton({
                element: this._options.button,
                title: this._options.text.fileInputTitle
            }).getButtonId();
        }

        this._generateExtraButtonSpecs();

        this._handleCameraAccess();

        if (this._options.paste.targetElement) {
            if (qq.PasteSupport) {
                this._pasteHandler = this._createPasteHandler();
            }
            else {
                this.log("Paste support module not found", "error");
            }
        }

        this._preventLeaveInProgress();

        this._imageGenerator = qq.ImageGenerator && new qq.ImageGenerator(qq.bind(this.log, this));
        this._refreshSessionData();

        this._succeededSinceLastAllComplete = [];
        this._failedSinceLastAllComplete = [];

        this._scaler = (qq.Scaler && new qq.Scaler(this._options.scaling, qq.bind(this.log, this))) || {};
        if (this._scaler.enabled) {
            this._customNewFileHandler = qq.bind(this._scaler.handleNewFile, this._scaler);
        }

        if (qq.TotalProgress && qq.supportedFeatures.progressBar) {
            this._totalProgress = new qq.TotalProgress(
                qq.bind(this._onTotalProgress, this),

                function(id) {
                    var entry = self._uploadData.retrieve({id: id});
                    return (entry && entry.size) || 0;
                }
            );
        }

        this._currentItemLimit = this._options.validation.itemLimit;
    };

    // Define the private & public API methods.
    qq.FineUploaderBasic.prototype = qq.basePublicApi;
    qq.extend(qq.FineUploaderBasic.prototype, qq.basePrivateApi);
}());

/*globals qq, XDomainRequest*/
/** Generic class for sending non-upload ajax requests and handling the associated responses **/
qq.AjaxRequester = function(o) {
    "use strict";

    var log, shouldParamsBeInQueryString,
        queue = [],
        requestData = {},
        options = {
            acceptHeader: null,
            validMethods: ["PATCH", "POST", "PUT"],
            method: "POST",
            contentType: "application/x-www-form-urlencoded",
            maxConnections: 3,
            customHeaders: {},
            endpointStore: {},
            paramsStore: {},
            mandatedParams: {},
            allowXRequestedWithAndCacheControl: true,
            successfulResponseCodes: {
                DELETE: [200, 202, 204],
                PATCH: [200, 201, 202, 203, 204],
                POST: [200, 201, 202, 203, 204],
                PUT: [200, 201, 202, 203, 204],
                GET: [200]
            },
            cors: {
                expected: false,
                sendCredentials: false
            },
            log: function(str, level) {},
            onSend: function(id) {},
            onComplete: function(id, xhrOrXdr, isError) {},
            onProgress: null
        };

    qq.extend(options, o);
    log = options.log;

    if (qq.indexOf(options.validMethods, options.method) < 0) {
        throw new Error("'" + options.method + "' is not a supported method for this type of request!");
    }

    // [Simple methods](http://www.w3.org/TR/cors/#simple-method)
    // are defined by the W3C in the CORS spec as a list of methods that, in part,
    // make a CORS request eligible to be exempt from preflighting.
    function isSimpleMethod() {
        return qq.indexOf(["GET", "POST", "HEAD"], options.method) >= 0;
    }

    // [Simple headers](http://www.w3.org/TR/cors/#simple-header)
    // are defined by the W3C in the CORS spec as a list of headers that, in part,
    // make a CORS request eligible to be exempt from preflighting.
    function containsNonSimpleHeaders(headers) {
        var containsNonSimple = false;

        qq.each(containsNonSimple, function(idx, header) {
            if (qq.indexOf(["Accept", "Accept-Language", "Content-Language", "Content-Type"], header) < 0) {
                containsNonSimple = true;
                return false;
            }
        });

        return containsNonSimple;
    }

    function isXdr(xhr) {
        //The `withCredentials` test is a commonly accepted way to determine if XHR supports CORS.
        return options.cors.expected && xhr.withCredentials === undefined;
    }

    // Returns either a new `XMLHttpRequest` or `XDomainRequest` instance.
    function getCorsAjaxTransport() {
        var xhrOrXdr;

        if (window.XMLHttpRequest || window.ActiveXObject) {
            xhrOrXdr = qq.createXhrInstance();

            if (xhrOrXdr.withCredentials === undefined) {
                xhrOrXdr = new XDomainRequest();
                // Workaround for XDR bug in IE9 - https://social.msdn.microsoft.com/Forums/ie/en-US/30ef3add-767c-4436-b8a9-f1ca19b4812e/ie9-rtm-xdomainrequest-issued-requests-may-abort-if-all-event-handlers-not-specified?forum=iewebdevelopment
                xhrOrXdr.onload = function() {};
                xhrOrXdr.onerror = function() {};
                xhrOrXdr.ontimeout = function() {};
                xhrOrXdr.onprogress = function() {};
            }
        }

        return xhrOrXdr;
    }

    // Returns either a new XHR/XDR instance, or an existing one for the associated `File` or `Blob`.
    function getXhrOrXdr(id, suppliedXhr) {
        var xhrOrXdr = requestData[id].xhr;

        if (!xhrOrXdr) {
            if (suppliedXhr) {
                xhrOrXdr = suppliedXhr;
            }
            else {
                if (options.cors.expected) {
                    xhrOrXdr = getCorsAjaxTransport();
                }
                else {
                    xhrOrXdr = qq.createXhrInstance();
                }
            }

            requestData[id].xhr = xhrOrXdr;
        }

        return xhrOrXdr;
    }

    // Removes element from queue, sends next request
    function dequeue(id) {
        var i = qq.indexOf(queue, id),
            max = options.maxConnections,
            nextId;

        delete requestData[id];
        queue.splice(i, 1);

        if (queue.length >= max && i < max) {
            nextId = queue[max - 1];
            sendRequest(nextId);
        }
    }

    function onComplete(id, xdrError) {
        var xhr = getXhrOrXdr(id),
            method = options.method,
            isError = xdrError === true;

        dequeue(id);

        if (isError) {
            log(method + " request for " + id + " has failed", "error");
        }
        else if (!isXdr(xhr) && !isResponseSuccessful(xhr.status)) {
            isError = true;
            log(method + " request for " + id + " has failed - response code " + xhr.status, "error");
        }

        options.onComplete(id, xhr, isError);
    }

    function getParams(id) {
        var onDemandParams = requestData[id].additionalParams,
            mandatedParams = options.mandatedParams,
            params;

        if (options.paramsStore.get) {
            params = options.paramsStore.get(id);
        }

        if (onDemandParams) {
            qq.each(onDemandParams, function(name, val) {
                params = params || {};
                params[name] = val;
            });
        }

        if (mandatedParams) {
            qq.each(mandatedParams, function(name, val) {
                params = params || {};
                params[name] = val;
            });
        }

        return params;
    }

    function sendRequest(id, optXhr) {
        var xhr = getXhrOrXdr(id, optXhr),
            method = options.method,
            params = getParams(id),
            payload = requestData[id].payload,
            url;

        options.onSend(id);

        url = createUrl(id, params, requestData[id].additionalQueryParams);

        // XDR and XHR status detection APIs differ a bit.
        if (isXdr(xhr)) {
            xhr.onload = getXdrLoadHandler(id);
            xhr.onerror = getXdrErrorHandler(id);
        }
        else {
            xhr.onreadystatechange = getXhrReadyStateChangeHandler(id);
        }

        registerForUploadProgress(id);

        // The last parameter is assumed to be ignored if we are actually using `XDomainRequest`.
        xhr.open(method, url, true);

        // Instruct the transport to send cookies along with the CORS request,
        // unless we are using `XDomainRequest`, which is not capable of this.
        if (options.cors.expected && options.cors.sendCredentials && !isXdr(xhr)) {
            xhr.withCredentials = true;
        }

        setHeaders(id);

        log("Sending " + method + " request for " + id);

        if (payload) {
            xhr.send(payload);
        }
        else if (shouldParamsBeInQueryString || !params) {
            xhr.send();
        }
        else if (params && options.contentType && options.contentType.toLowerCase().indexOf("application/x-www-form-urlencoded") >= 0) {
            xhr.send(qq.obj2url(params, ""));
        }
        else if (params && options.contentType && options.contentType.toLowerCase().indexOf("application/json") >= 0) {
            xhr.send(JSON.stringify(params));
        }
        else {
            xhr.send(params);
        }

        return xhr;
    }

    function createUrl(id, params, additionalQueryParams) {
        var endpoint = options.endpointStore.get(id),
            addToPath = requestData[id].addToPath;

        /*jshint -W116,-W041 */
        if (addToPath != undefined) {
            endpoint += "/" + addToPath;
        }

        if (shouldParamsBeInQueryString && params) {
            endpoint = qq.obj2url(params, endpoint);
        }

        if (additionalQueryParams) {
            endpoint = qq.obj2url(additionalQueryParams, endpoint);
        }

        return endpoint;
    }

    // Invoked by the UA to indicate a number of possible states that describe
    // a live `XMLHttpRequest` transport.
    function getXhrReadyStateChangeHandler(id) {
        return function() {
            if (getXhrOrXdr(id).readyState === 4) {
                onComplete(id);
            }
        };
    }

    function registerForUploadProgress(id) {
        var onProgress = options.onProgress;

        if (onProgress) {
            getXhrOrXdr(id).upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    onProgress(id, e.loaded, e.total);
                }
            };
        }
    }

    // This will be called by IE to indicate **success** for an associated
    // `XDomainRequest` transported request.
    function getXdrLoadHandler(id) {
        return function() {
            onComplete(id);
        };
    }

    // This will be called by IE to indicate **failure** for an associated
    // `XDomainRequest` transported request.
    function getXdrErrorHandler(id) {
        return function() {
            onComplete(id, true);
        };
    }

    function setHeaders(id) {
        var xhr = getXhrOrXdr(id),
            customHeaders = options.customHeaders,
            onDemandHeaders = requestData[id].additionalHeaders || {},
            method = options.method,
            allHeaders = {};

        // If XDomainRequest is being used, we can't set headers, so just ignore this block.
        if (!isXdr(xhr)) {
            options.acceptHeader && xhr.setRequestHeader("Accept", options.acceptHeader);

            // Only attempt to add X-Requested-With & Cache-Control if permitted
            if (options.allowXRequestedWithAndCacheControl) {
                // Do not add X-Requested-With & Cache-Control if this is a cross-origin request
                // OR the cross-origin request contains a non-simple method or header.
                // This is done to ensure a preflight is not triggered exclusively based on the
                // addition of these 2 non-simple headers.
                if (!options.cors.expected || (!isSimpleMethod() || containsNonSimpleHeaders(customHeaders))) {
                    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                    xhr.setRequestHeader("Cache-Control", "no-cache");
                }
            }

            if (options.contentType && (method === "POST" || method === "PUT")) {
                xhr.setRequestHeader("Content-Type", options.contentType);
            }

            qq.extend(allHeaders, qq.isFunction(customHeaders) ? customHeaders(id) : customHeaders);
            qq.extend(allHeaders, onDemandHeaders);

            qq.each(allHeaders, function(name, val) {
                xhr.setRequestHeader(name, val);
            });
        }
    }

    function isResponseSuccessful(responseCode) {
        return qq.indexOf(options.successfulResponseCodes[options.method], responseCode) >= 0;
    }

    function prepareToSend(id, optXhr, addToPath, additionalParams, additionalQueryParams, additionalHeaders, payload) {
        requestData[id] = {
            addToPath: addToPath,
            additionalParams: additionalParams,
            additionalQueryParams: additionalQueryParams,
            additionalHeaders: additionalHeaders,
            payload: payload
        };

        var len = queue.push(id);

        // if too many active connections, wait...
        if (len <= options.maxConnections) {
            return sendRequest(id, optXhr);
        }
    }

    shouldParamsBeInQueryString = options.method === "GET" || options.method === "DELETE";

    qq.extend(this, {
        // Start the process of sending the request.  The ID refers to the file associated with the request.
        initTransport: function(id) {
            var path, params, headers, payload, cacheBuster, additionalQueryParams;

            return {
                // Optionally specify the end of the endpoint path for the request.
                withPath: function(appendToPath) {
                    path = appendToPath;
                    return this;
                },

                // Optionally specify additional parameters to send along with the request.
                // These will be added to the query string for GET/DELETE requests or the payload
                // for POST/PUT requests.  The Content-Type of the request will be used to determine
                // how these parameters should be formatted as well.
                withParams: function(additionalParams) {
                    params = additionalParams;
                    return this;
                },

                withQueryParams: function(_additionalQueryParams_) {
                    additionalQueryParams = _additionalQueryParams_;
                    return this;
                },

                // Optionally specify additional headers to send along with the request.
                withHeaders: function(additionalHeaders) {
                    headers = additionalHeaders;
                    return this;
                },

                // Optionally specify a payload/body for the request.
                withPayload: function(thePayload) {
                    payload = thePayload;
                    return this;
                },

                // Appends a cache buster (timestamp) to the request URL as a query parameter (only if GET or DELETE)
                withCacheBuster: function() {
                    cacheBuster = true;
                    return this;
                },

                // Send the constructed request.
                send: function(optXhr) {
                    if (cacheBuster && qq.indexOf(["GET", "DELETE"], options.method) >= 0) {
                        params.qqtimestamp = new Date().getTime();
                    }

                    return prepareToSend(id, optXhr, path, params, additionalQueryParams, headers, payload);
                }
            };
        },

        canceled: function(id) {
            dequeue(id);
        }
    });
};

/* globals qq */
/**
 * Common upload handler functions.
 *
 * @constructor
 */
qq.UploadHandler = function(spec) {
    "use strict";

    var proxy = spec.proxy,
        fileState = {},
        onCancel = proxy.onCancel,
        getName = proxy.getName;

    qq.extend(this, {
        add: function(id, fileItem) {
            fileState[id] = fileItem;
            fileState[id].temp = {};
        },

        cancel: function(id) {
            var self = this,
                cancelFinalizationEffort = new qq.Promise(),
                onCancelRetVal = onCancel(id, getName(id), cancelFinalizationEffort);

            onCancelRetVal.then(function() {
                if (self.isValid(id)) {
                    fileState[id].canceled = true;
                    self.expunge(id);
                }
                cancelFinalizationEffort.success();
            });
        },

        expunge: function(id) {
            delete fileState[id];
        },

        getThirdPartyFileId: function(id) {
            return fileState[id].key;
        },

        isValid: function(id) {
            return fileState[id] !== undefined;
        },

        reset: function() {
            fileState = {};
        },

        _getFileState: function(id) {
            return fileState[id];
        },

        _setThirdPartyFileId: function(id, thirdPartyFileId) {
            fileState[id].key = thirdPartyFileId;
        },

        _wasCanceled: function(id) {
            return !!fileState[id].canceled;
        }
    });
};

/*globals qq*/
/**
 * Base upload handler module.  Controls more specific handlers.
 *
 * @param o Options.  Passed along to the specific handler submodule as well.
 * @param namespace [optional] Namespace for the specific handler.
 */
qq.UploadHandlerController = function(o, namespace) {
    "use strict";

    var controller = this,
        chunkingPossible = false,
        concurrentChunkingPossible = false,
        chunking, preventRetryResponse, log, handler,

    options = {
        paramsStore: {},
        maxConnections: 3, // maximum number of concurrent uploads
        chunking: {
            enabled: false,
            multiple: {
                enabled: false
            }
        },
        log: function(str, level) {},
        onProgress: function(id, fileName, loaded, total) {},
        onComplete: function(id, fileName, response, xhr) {},
        onCancel: function(id, fileName) {},
        onUploadPrep: function(id) {}, // Called if non-trivial operations will be performed before onUpload
        onUpload: function(id, fileName) {},
        onUploadChunk: function(id, fileName, chunkData) {},
        onUploadChunkSuccess: function(id, chunkData, response, xhr) {},
        onAutoRetry: function(id, fileName, response, xhr) {},
        onResume: function(id, fileName, chunkData) {},
        onUuidChanged: function(id, newUuid) {},
        getName: function(id) {},
        setSize: function(id, newSize) {},
        isQueued: function(id) {},
        getIdsInProxyGroup: function(id) {},
        getIdsInBatch: function(id) {}
    },

    chunked = {
        // Called when each chunk has uploaded successfully
        done: function(id, chunkIdx, response, xhr) {
            var chunkData = handler._getChunkData(id, chunkIdx);

            handler._getFileState(id).attemptingResume = false;

            delete handler._getFileState(id).temp.chunkProgress[chunkIdx];
            handler._getFileState(id).loaded += chunkData.size;

            options.onUploadChunkSuccess(id, handler._getChunkDataForCallback(chunkData), response, xhr);
        },

        // Called when all chunks have been successfully uploaded and we want to ask the handler to perform any
        // logic associated with closing out the file, such as combining the chunks.
        finalize: function(id) {
            var size = options.getSize(id),
                name = options.getName(id);

            log("All chunks have been uploaded for " + id + " - finalizing....");
            handler.finalizeChunks(id).then(
                function(response, xhr) {
                    log("Finalize successful for " + id);

                    var normaizedResponse = upload.normalizeResponse(response, true);

                    options.onProgress(id, name, size, size);
                    handler._maybeDeletePersistedChunkData(id);
                    upload.cleanup(id, normaizedResponse, xhr);
                },
                function(response, xhr) {
                    var normaizedResponse = upload.normalizeResponse(response, false);

                    log("Problem finalizing chunks for file ID " + id + " - " + normaizedResponse.error, "error");

                    if (normaizedResponse.reset) {
                        chunked.reset(id);
                    }

                    if (!options.onAutoRetry(id, name, normaizedResponse, xhr)) {
                        upload.cleanup(id, normaizedResponse, xhr);
                    }
                }
            );
        },

        hasMoreParts: function(id) {
            return !!handler._getFileState(id).chunking.remaining.length;
        },

        nextPart: function(id) {
            var nextIdx = handler._getFileState(id).chunking.remaining.shift();

            if (nextIdx >= handler._getTotalChunks(id)) {
                nextIdx = null;
            }

            return nextIdx;
        },

        reset: function(id) {
            log("Server or callback has ordered chunking effort to be restarted on next attempt for item ID " + id, "error");

            handler._maybeDeletePersistedChunkData(id);
            handler.reevaluateChunking(id);
            handler._getFileState(id).loaded = 0;
        },

        sendNext: function(id) {
            var size = options.getSize(id),
                name = options.getName(id),
                chunkIdx = chunked.nextPart(id),
                chunkData = handler._getChunkData(id, chunkIdx),
                resuming = handler._getFileState(id).attemptingResume,
                inProgressChunks = handler._getFileState(id).chunking.inProgress || [];

            if (handler._getFileState(id).loaded == null) {
                handler._getFileState(id).loaded = 0;
            }

            // Don't follow-through with the resume attempt if the integrator returns false from onResume
            if (resuming && options.onResume(id, name, chunkData) === false) {
                chunked.reset(id);
                chunkIdx = chunked.nextPart(id);
                chunkData = handler._getChunkData(id, chunkIdx);
                resuming = false;
            }

            // If all chunks have already uploaded successfully, we must be re-attempting the finalize step.
            if (chunkIdx == null && inProgressChunks.length === 0) {
                chunked.finalize(id);
            }

            // Send the next chunk
            else {
                log(qq.format("Sending chunked upload request for item {}.{}, bytes {}-{} of {}.", id, chunkIdx, chunkData.start + 1, chunkData.end, size));
                options.onUploadChunk(id, name, handler._getChunkDataForCallback(chunkData));
                inProgressChunks.push(chunkIdx);
                handler._getFileState(id).chunking.inProgress = inProgressChunks;

                if (concurrentChunkingPossible) {
                    connectionManager.open(id, chunkIdx);
                }

                if (concurrentChunkingPossible && connectionManager.available() && handler._getFileState(id).chunking.remaining.length) {
                    chunked.sendNext(id);
                }

                handler.uploadChunk(id, chunkIdx, resuming).then(
                    // upload chunk success
                    function success(response, xhr) {
                        log("Chunked upload request succeeded for " + id + ", chunk " + chunkIdx);

                        handler.clearCachedChunk(id, chunkIdx);

                        var inProgressChunks = handler._getFileState(id).chunking.inProgress || [],
                            responseToReport = upload.normalizeResponse(response, true),
                            inProgressChunkIdx = qq.indexOf(inProgressChunks, chunkIdx);

                        log(qq.format("Chunk {} for file {} uploaded successfully.", chunkIdx, id));

                        chunked.done(id, chunkIdx, responseToReport, xhr);

                        if (inProgressChunkIdx >= 0) {
                            inProgressChunks.splice(inProgressChunkIdx, 1);
                        }

                        handler._maybePersistChunkedState(id);

                        if (!chunked.hasMoreParts(id) && inProgressChunks.length === 0) {
                            chunked.finalize(id);
                        }
                        else if (chunked.hasMoreParts(id)) {
                            chunked.sendNext(id);
                        }
                        else {
                            log(qq.format("File ID {} has no more chunks to send and these chunk indexes are still marked as in-progress: {}", id, JSON.stringify(inProgressChunks)));
                        }
                    },

                    // upload chunk failure
                    function failure(response, xhr) {
                        log("Chunked upload request failed for " + id + ", chunk " + chunkIdx);

                        handler.clearCachedChunk(id, chunkIdx);

                        var responseToReport = upload.normalizeResponse(response, false),
                            inProgressIdx;

                        if (responseToReport.reset) {
                            chunked.reset(id);
                        }
                        else {
                            inProgressIdx = qq.indexOf(handler._getFileState(id).chunking.inProgress, chunkIdx);
                            if (inProgressIdx >= 0) {
                                handler._getFileState(id).chunking.inProgress.splice(inProgressIdx, 1);
                                handler._getFileState(id).chunking.remaining.unshift(chunkIdx);
                            }
                        }

                        // We may have aborted all other in-progress chunks for this file due to a failure.
                        // If so, ignore the failures associated with those aborts.
                        if (!handler._getFileState(id).temp.ignoreFailure) {
                            // If this chunk has failed, we want to ignore all other failures of currently in-progress
                            // chunks since they will be explicitly aborted
                            if (concurrentChunkingPossible) {
                                handler._getFileState(id).temp.ignoreFailure = true;

                                log(qq.format("Going to attempt to abort these chunks: {}. These are currently in-progress: {}.", JSON.stringify(Object.keys(handler._getXhrs(id))), JSON.stringify(handler._getFileState(id).chunking.inProgress)));
                                qq.each(handler._getXhrs(id), function(ckid, ckXhr) {
                                    log(qq.format("Attempting to abort file {}.{}. XHR readyState {}. ", id, ckid, ckXhr.readyState));
                                    ckXhr.abort();
                                    // Flag the transport, in case we are waiting for some other async operation
                                    // to complete before attempting to upload the chunk
                                    ckXhr._cancelled = true;
                                });

                                // We must indicate that all aborted chunks are no longer in progress
                                handler.moveInProgressToRemaining(id);

                                // Free up any connections used by these chunks, but don't allow any
                                // other files to take up the connections (until we have exhausted all auto-retries)
                                connectionManager.free(id, true);
                            }

                            if (!options.onAutoRetry(id, name, responseToReport, xhr)) {
                                // If one chunk fails, abort all of the others to avoid odd race conditions that occur
                                // if a chunk succeeds immediately after one fails before we have determined if the upload
                                // is a failure or not.
                                upload.cleanup(id, responseToReport, xhr);
                            }
                        }
                    }
                )
                    .done(function() {
                        handler.clearXhr(id, chunkIdx);
                    }) ;
            }
        }
    },

    connectionManager = {
        _open: [],
        _openChunks: {},
        _waiting: [],

        available: function() {
            var max = options.maxConnections,
                openChunkEntriesCount = 0,
                openChunksCount = 0;

            qq.each(connectionManager._openChunks, function(fileId, openChunkIndexes) {
                openChunkEntriesCount++;
                openChunksCount += openChunkIndexes.length;
            });

            return max - (connectionManager._open.length - openChunkEntriesCount + openChunksCount);
        },

        /**
         * Removes element from queue, starts upload of next
         */
        free: function(id, dontAllowNext) {
            var allowNext = !dontAllowNext,
                waitingIndex = qq.indexOf(connectionManager._waiting, id),
                connectionsIndex = qq.indexOf(connectionManager._open, id),
                nextId;

            delete connectionManager._openChunks[id];

            if (upload.getProxyOrBlob(id) instanceof qq.BlobProxy) {
                log("Generated blob upload has ended for " + id + ", disposing generated blob.");
                delete handler._getFileState(id).file;
            }

            // If this file was not consuming a connection, it was just waiting, so remove it from the waiting array
            if (waitingIndex >= 0) {
                connectionManager._waiting.splice(waitingIndex, 1);
            }
            // If this file was consuming a connection, allow the next file to be uploaded
            else if (allowNext && connectionsIndex >= 0) {
                connectionManager._open.splice(connectionsIndex, 1);

                nextId = connectionManager._waiting.shift();
                if (nextId >= 0) {
                    connectionManager._open.push(nextId);
                    upload.start(nextId);
                }
            }
        },

        getWaitingOrConnected: function() {
            var waitingOrConnected = [];

            // Chunked files may have multiple connections open per chunk (if concurrent chunking is enabled)
            // We need to grab the file ID of any file that has at least one chunk consuming a connection.
            qq.each(connectionManager._openChunks, function(fileId, chunks) {
                if (chunks && chunks.length) {
                    waitingOrConnected.push(parseInt(fileId));
                }
            });

            // For non-chunked files, only one connection will be consumed per file.
            // This is where we aggregate those file IDs.
            qq.each(connectionManager._open, function(idx, fileId) {
                if (!connectionManager._openChunks[fileId]) {
                    waitingOrConnected.push(parseInt(fileId));
                }
            });

            // There may be files waiting for a connection.
            waitingOrConnected = waitingOrConnected.concat(connectionManager._waiting);

            return waitingOrConnected;
        },

        isUsingConnection: function(id) {
            return qq.indexOf(connectionManager._open, id) >= 0;
        },

        open: function(id, chunkIdx) {
            if (chunkIdx == null) {
                connectionManager._waiting.push(id);
            }

            if (connectionManager.available()) {
                if (chunkIdx == null) {
                    connectionManager._waiting.pop();
                    connectionManager._open.push(id);
                }
                else {
                    (function() {
                        var openChunksEntry = connectionManager._openChunks[id] || [];
                        openChunksEntry.push(chunkIdx);
                        connectionManager._openChunks[id] = openChunksEntry;
                    }());
                }

                return true;
            }

            return false;
        },

        reset: function() {
            connectionManager._waiting = [];
            connectionManager._open = [];
        }
    },

    simple = {
        send: function(id, name) {
            handler._getFileState(id).loaded = 0;

            log("Sending simple upload request for " + id);
            handler.uploadFile(id).then(
                function(response, optXhr) {
                    log("Simple upload request succeeded for " + id);

                    var responseToReport = upload.normalizeResponse(response, true),
                        size = options.getSize(id);

                    options.onProgress(id, name, size, size);
                    upload.maybeNewUuid(id, responseToReport);
                    upload.cleanup(id, responseToReport, optXhr);
                },

                function(response, optXhr) {
                    log("Simple upload request failed for " + id);

                    var responseToReport = upload.normalizeResponse(response, false);

                    if (!options.onAutoRetry(id, name, responseToReport, optXhr)) {
                        upload.cleanup(id, responseToReport, optXhr);
                    }
                }
            );
        }
    },

    upload = {
        cancel: function(id) {
            log("Cancelling " + id);
            options.paramsStore.remove(id);
            connectionManager.free(id);
        },

        cleanup: function(id, response, optXhr) {
            var name = options.getName(id);

            options.onComplete(id, name, response, optXhr);

            if (handler._getFileState(id)) {
                handler._clearXhrs && handler._clearXhrs(id);
            }

            connectionManager.free(id);
        },

        // Returns a qq.BlobProxy, or an actual File/Blob if no proxy is involved, or undefined
        // if none of these are available for the ID
        getProxyOrBlob: function(id) {
            return (handler.getProxy && handler.getProxy(id)) ||
                (handler.getFile && handler.getFile(id));
        },

        initHandler: function() {
            var handlerType = namespace ? qq[namespace] : qq.traditional,
                handlerModuleSubtype = qq.supportedFeatures.ajaxUploading ? "Xhr" : "Form";

            handler = new handlerType[handlerModuleSubtype + "UploadHandler"](
                options,
                {
                    getDataByUuid: options.getDataByUuid,
                    getName: options.getName,
                    getSize: options.getSize,
                    getUuid: options.getUuid,
                    log: log,
                    onCancel: options.onCancel,
                    onProgress: options.onProgress,
                    onUuidChanged: options.onUuidChanged
                }
            );

            if (handler._removeExpiredChunkingRecords) {
                handler._removeExpiredChunkingRecords();
            }
        },

        isDeferredEligibleForUpload: function(id) {
            return options.isQueued(id);
        },

        // For Blobs that are part of a group of generated images, along with a reference image,
        // this will ensure the blobs in the group are uploaded in the order they were triggered,
        // even if some async processing must be completed on one or more Blobs first.
        maybeDefer: function(id, blob) {
            // If we don't have a file/blob yet & no file/blob exists for this item, request it,
            // and then submit the upload to the specific handler once the blob is available.
            // ASSUMPTION: This condition will only ever be true if XHR uploading is supported.
            if (blob && !handler.getFile(id) && blob instanceof qq.BlobProxy) {

                // Blob creation may take some time, so the caller may want to update the
                // UI to indicate that an operation is in progress, even before the actual
                // upload begins and an onUpload callback is invoked.
                options.onUploadPrep(id);

                log("Attempting to generate a blob on-demand for " + id);
                blob.create().then(function(generatedBlob) {
                    log("Generated an on-demand blob for " + id);

                    // Update record associated with this file by providing the generated Blob
                    handler.updateBlob(id, generatedBlob);

                    // Propagate the size for this generated Blob
                    options.setSize(id, generatedBlob.size);

                    // Order handler to recalculate chunking possibility, if applicable
                    handler.reevaluateChunking(id);

                    upload.maybeSendDeferredFiles(id);
                },

                // Blob could not be generated.  Fail the upload & attempt to prevent retries.  Also bubble error message.
                function(errorMessage) {
                    var errorResponse = {};

                    if (errorMessage) {
                        errorResponse.error = errorMessage;
                    }

                    log(qq.format("Failed to generate blob for ID {}.  Error message: {}.", id, errorMessage), "error");

                    options.onComplete(id, options.getName(id), qq.extend(errorResponse, preventRetryResponse), null);
                    upload.maybeSendDeferredFiles(id);
                    connectionManager.free(id);
                });
            }
            else {
                return upload.maybeSendDeferredFiles(id);
            }

            return false;
        },

        // Upload any grouped blobs, in the proper order, that are ready to be uploaded
        maybeSendDeferredFiles: function(id) {
            var idsInGroup = options.getIdsInProxyGroup(id),
                uploadedThisId = false;

            if (idsInGroup && idsInGroup.length) {
                log("Maybe ready to upload proxy group file " + id);

                qq.each(idsInGroup, function(idx, idInGroup) {
                    if (upload.isDeferredEligibleForUpload(idInGroup) && !!handler.getFile(idInGroup)) {
                        uploadedThisId = idInGroup === id;
                        upload.now(idInGroup);
                    }
                    else if (upload.isDeferredEligibleForUpload(idInGroup)) {
                        return false;
                    }
                });
            }
            else {
                uploadedThisId = true;
                upload.now(id);
            }

            return uploadedThisId;
        },

        maybeNewUuid: function(id, response) {
            if (response.newUuid !== undefined) {
                options.onUuidChanged(id, response.newUuid);
            }
        },

        // The response coming from handler implementations may be in various formats.
        // Instead of hoping a promise nested 5 levels deep will always return an object
        // as its first param, let's just normalize the response here.
        normalizeResponse: function(originalResponse, successful) {
            var response = originalResponse;

            // The passed "response" param may not be a response at all.
            // It could be a string, detailing the error, for example.
            if (!qq.isObject(originalResponse)) {
                response = {};

                if (qq.isString(originalResponse) && !successful) {
                    response.error = originalResponse;
                }
            }

            response.success = successful;

            return response;
        },

        now: function(id) {
            var name = options.getName(id);

            if (!controller.isValid(id)) {
                throw new qq.Error(id + " is not a valid file ID to upload!");
            }

            options.onUpload(id, name);

            if (chunkingPossible && handler._shouldChunkThisFile(id)) {
                chunked.sendNext(id);
            }
            else {
                simple.send(id, name);
            }
        },

        start: function(id) {
            var blobToUpload = upload.getProxyOrBlob(id);

            if (blobToUpload) {
                return upload.maybeDefer(id, blobToUpload);
            }
            else {
                upload.now(id);
                return true;
            }
        }
    };

    qq.extend(this, {
        /**
         * Adds file or file input to the queue
         **/
        add: function(id, file) {
            handler.add.apply(this, arguments);
        },

        /**
         * Sends the file identified by id
         */
        upload: function(id) {
            if (connectionManager.open(id)) {
                return upload.start(id);
            }
            return false;
        },

        retry: function(id) {
            // On retry, if concurrent chunking has been enabled, we may have aborted all other in-progress chunks
            // for a file when encountering a failed chunk upload.  We then signaled the controller to ignore
            // all failures associated with these aborts.  We are now retrying, so we don't want to ignore
            // any more failures at this point.
            if (concurrentChunkingPossible) {
                handler._getFileState(id).temp.ignoreFailure = false;
            }

            // If we are attempting to retry a file that is already consuming a connection, this is likely an auto-retry.
            // Just go ahead and ask the handler to upload again.
            if (connectionManager.isUsingConnection(id)) {
                return upload.start(id);
            }

            // If we are attempting to retry a file that is not currently consuming a connection,
            // this is likely a manual retry attempt.  We will need to ensure a connection is available
            // before the retry commences.
            else {
                return controller.upload(id);
            }
        },

        /**
         * Cancels file upload by id
         */
        cancel: function(id) {
            var cancelRetVal = handler.cancel(id);

            if (qq.isGenericPromise(cancelRetVal)) {
                cancelRetVal.then(function() {
                    upload.cancel(id);
                });
            }
            else if (cancelRetVal !== false) {
                upload.cancel(id);
            }
        },

        /**
         * Cancels all queued or in-progress uploads
         */
        cancelAll: function() {
            var waitingOrConnected = connectionManager.getWaitingOrConnected(),
                i;

            // ensure files are cancelled in reverse order which they were added
            // to avoid a flash of time where a queued file begins to upload before it is canceled
            if (waitingOrConnected.length) {
                for (i = waitingOrConnected.length - 1; i >= 0; i--) {
                    controller.cancel(waitingOrConnected[i]);
                }
            }

            connectionManager.reset();
        },

        // Returns a File, Blob, or the Blob/File for the reference/parent file if the targeted blob is a proxy.
        // Undefined if no file record is available.
        getFile: function(id) {
            if (handler.getProxy && handler.getProxy(id)) {
                return handler.getProxy(id).referenceBlob;
            }

            return handler.getFile && handler.getFile(id);
        },

        // Returns true if the Blob associated with the ID is related to a proxy s
        isProxied: function(id) {
            return !!(handler.getProxy && handler.getProxy(id));
        },

        getInput: function(id) {
            if (handler.getInput) {
                return handler.getInput(id);
            }
        },

        reset: function() {
            log("Resetting upload handler");
            controller.cancelAll();
            connectionManager.reset();
            handler.reset();
        },

        expunge: function(id) {
            if (controller.isValid(id)) {
                return handler.expunge(id);
            }
        },

        /**
         * Determine if the file exists.
         */
        isValid: function(id) {
            return handler.isValid(id);
        },

        getResumableFilesData: function() {
            if (handler.getResumableFilesData) {
                return handler.getResumableFilesData();
            }
            return [];
        },

        /**
         * This may or may not be implemented, depending on the handler.  For handlers where a third-party ID is
         * available (such as the "key" for Amazon S3), this will return that value.  Otherwise, the return value
         * will be undefined.
         *
         * @param id Internal file ID
         * @returns {*} Some identifier used by a 3rd-party service involved in the upload process
         */
        getThirdPartyFileId: function(id) {
            if (controller.isValid(id)) {
                return handler.getThirdPartyFileId(id);
            }
        },

        /**
         * Attempts to pause the associated upload if the specific handler supports this and the file is "valid".
         * @param id ID of the upload/file to pause
         * @returns {boolean} true if the upload was paused
         */
        pause: function(id) {
            if (controller.isResumable(id) && handler.pause && controller.isValid(id) && handler.pause(id)) {
                connectionManager.free(id);
                handler.moveInProgressToRemaining(id);
                return true;
            }
            return false;
        },

        // True if the file is eligible for pause/resume.
        isResumable: function(id) {
            return !!handler.isResumable && handler.isResumable(id);
        }
    });

    qq.extend(options, o);
    log = options.log;
    chunkingPossible = options.chunking.enabled && qq.supportedFeatures.chunking;
    concurrentChunkingPossible = chunkingPossible && options.chunking.concurrent.enabled;

    preventRetryResponse = (function() {
        var response = {};

        response[options.preventRetryParam] = true;

        return response;
    }());

    upload.initHandler();
};

/* globals qq */
/**
 * Common APIs exposed to creators of upload via form/iframe handlers.  This is reused and possibly overridden
 * in some cases by specific form upload handlers.
 *
 * @constructor
 */
qq.FormUploadHandler = function(spec) {
    "use strict";

    var options = spec.options,
        handler = this,
        proxy = spec.proxy,
        formHandlerInstanceId = qq.getUniqueId(),
        onloadCallbacks = {},
        detachLoadEvents = {},
        postMessageCallbackTimers = {},
        isCors = options.isCors,
        inputName = options.inputName,
        getUuid = proxy.getUuid,
        log = proxy.log,
        corsMessageReceiver = new qq.WindowReceiveMessage({log: log});

    /**
     * Remove any trace of the file from the handler.
     *
     * @param id ID of the associated file
     */
    function expungeFile(id) {
        delete detachLoadEvents[id];

        // If we are dealing with CORS, we might still be waiting for a response from a loaded iframe.
        // In that case, terminate the timer waiting for a message from the loaded iframe
        // and stop listening for any more messages coming from this iframe.
        if (isCors) {
            clearTimeout(postMessageCallbackTimers[id]);
            delete postMessageCallbackTimers[id];
            corsMessageReceiver.stopReceivingMessages(id);
        }

        var iframe = document.getElementById(handler._getIframeName(id));
        if (iframe) {
            // To cancel request set src to something else.  We use src="javascript:false;"
            // because it doesn't trigger ie6 prompt on https
            /* jshint scripturl:true */
            iframe.setAttribute("src", "javascript:false;");

            qq(iframe).remove();
        }
    }

    /**
     * @param iframeName `document`-unique Name of the associated iframe
     * @returns {*} ID of the associated file
     */
    function getFileIdForIframeName(iframeName) {
        return iframeName.split("_")[0];
    }

    /**
     * Generates an iframe to be used as a target for upload-related form submits.  This also adds the iframe
     * to the current `document`.  Note that the iframe is hidden from view.
     *
     * @param name Name of the iframe.
     * @returns {HTMLIFrameElement} The created iframe
     */
    function initIframeForUpload(name) {
        var iframe = qq.toElement("<iframe src='javascript:false;' name='" + name + "' />");

        iframe.setAttribute("id", name);

        iframe.style.display = "none";
        document.body.appendChild(iframe);

        return iframe;
    }

    /**
     * If we are in CORS mode, we must listen for messages (containing the server response) from the associated
     * iframe, since we cannot directly parse the content of the iframe due to cross-origin restrictions.
     *
     * @param iframe Listen for messages on this iframe.
     * @param callback Invoke this callback with the message from the iframe.
     */
    function registerPostMessageCallback(iframe, callback) {
        var iframeName = iframe.id,
            fileId = getFileIdForIframeName(iframeName),
            uuid = getUuid(fileId);

        onloadCallbacks[uuid] = callback;

        // When the iframe has loaded (after the server responds to an upload request)
        // declare the attempt a failure if we don't receive a valid message shortly after the response comes in.
        detachLoadEvents[fileId] = qq(iframe).attach("load", function() {
            if (handler.getInput(fileId)) {
                log("Received iframe load event for CORS upload request (iframe name " + iframeName + ")");

                postMessageCallbackTimers[iframeName] = setTimeout(function() {
                    var errorMessage = "No valid message received from loaded iframe for iframe name " + iframeName;
                    log(errorMessage, "error");
                    callback({
                        error: errorMessage
                    });
                }, 1000);
            }
        });

        // Listen for messages coming from this iframe.  When a message has been received, cancel the timer
        // that declares the upload a failure if a message is not received within a reasonable amount of time.
        corsMessageReceiver.receiveMessage(iframeName, function(message) {
            log("Received the following window message: '" + message + "'");
            var fileId = getFileIdForIframeName(iframeName),
                response = handler._parseJsonResponse(message),
                uuid = response.uuid,
                onloadCallback;

            if (uuid && onloadCallbacks[uuid]) {
                log("Handling response for iframe name " + iframeName);
                clearTimeout(postMessageCallbackTimers[iframeName]);
                delete postMessageCallbackTimers[iframeName];

                handler._detachLoadEvent(iframeName);

                onloadCallback = onloadCallbacks[uuid];

                delete onloadCallbacks[uuid];
                corsMessageReceiver.stopReceivingMessages(iframeName);
                onloadCallback(response);
            }
            else if (!uuid) {
                log("'" + message + "' does not contain a UUID - ignoring.");
            }
        });
    }

    qq.extend(this, new qq.UploadHandler(spec));

    qq.override(this, function(super_) {
        return {
            /**
             * Adds File or Blob to the queue
             **/
            add: function(id, fileInput) {
                super_.add(id, {input: fileInput});

                fileInput.setAttribute("name", inputName);

                // remove file input from DOM
                if (fileInput.parentNode) {
                    qq(fileInput).remove();
                }
            },

            expunge: function(id) {
                expungeFile(id);
                super_.expunge(id);
            },

            isValid: function(id) {
                return super_.isValid(id) &&
                    handler._getFileState(id).input !== undefined;
            }
        };
    });

    qq.extend(this, {
        getInput: function(id) {
            return handler._getFileState(id).input;
        },

        /**
         * This function either delegates to a more specific message handler if CORS is involved,
         * or simply registers a callback when the iframe has been loaded that invokes the passed callback
         * after determining if the content of the iframe is accessible.
         *
         * @param iframe Associated iframe
         * @param callback Callback to invoke after we have determined if the iframe content is accessible.
         */
        _attachLoadEvent: function(iframe, callback) {
            /*jslint eqeq: true*/
            var responseDescriptor;

            if (isCors) {
                registerPostMessageCallback(iframe, callback);
            }
            else {
                detachLoadEvents[iframe.id] = qq(iframe).attach("load", function() {
                    log("Received response for " + iframe.id);

                    // when we remove iframe from dom
                    // the request stops, but in IE load
                    // event fires
                    if (!iframe.parentNode) {
                        return;
                    }

                    try {
                        // fixing Opera 10.53
                        if (iframe.contentDocument &&
                            iframe.contentDocument.body &&
                            iframe.contentDocument.body.innerHTML == "false") {
                            // In Opera event is fired second time
                            // when body.innerHTML changed from false
                            // to server response approx. after 1 sec
                            // when we upload file with iframe
                            return;
                        }
                    }
                    catch (error) {
                        //IE may throw an "access is denied" error when attempting to access contentDocument on the iframe in some cases
                        log("Error when attempting to access iframe during handling of upload response (" + error.message + ")", "error");
                        responseDescriptor = {success: false};
                    }

                    callback(responseDescriptor);
                });
            }
        },

        /**
         * Creates an iframe with a specific document-unique name.
         *
         * @param id ID of the associated file
         * @returns {HTMLIFrameElement}
         */
        _createIframe: function(id) {
            var iframeName = handler._getIframeName(id);

            return initIframeForUpload(iframeName);
        },

        /**
         * Called when we are no longer interested in being notified when an iframe has loaded.
         *
         * @param id Associated file ID
         */
        _detachLoadEvent: function(id) {
            if (detachLoadEvents[id] !== undefined) {
                detachLoadEvents[id]();
                delete detachLoadEvents[id];
            }
        },

        /**
         * @param fileId ID of the associated file
         * @returns {string} The `document`-unique name of the iframe
         */
        _getIframeName: function(fileId) {
            return fileId + "_" + formHandlerInstanceId;
        },

        /**
         * Generates a form element and appends it to the `document`.  When the form is submitted, a specific iframe is targeted.
         * The name of the iframe is passed in as a property of the spec parameter, and must be unique in the `document`.  Note
         * that the form is hidden from view.
         *
         * @param spec An object containing various properties to be used when constructing the form.  Required properties are
         * currently: `method`, `endpoint`, `params`, `paramsInBody`, and `targetName`.
         * @returns {HTMLFormElement} The created form
         */
        _initFormForUpload: function(spec) {
            var method = spec.method,
                endpoint = spec.endpoint,
                params = spec.params,
                paramsInBody = spec.paramsInBody,
                targetName = spec.targetName,
                form = qq.toElement("<form method='" + method + "' enctype='multipart/form-data'></form>"),
                url = endpoint;

            if (paramsInBody) {
                qq.obj2Inputs(params, form);
            }
            else {
                url = qq.obj2url(params, endpoint);
            }

            form.setAttribute("action", url);
            form.setAttribute("target", targetName);
            form.style.display = "none";
            document.body.appendChild(form);

            return form;
        },

        /**
         * @param innerHtmlOrMessage JSON message
         * @returns {*} The parsed response, or an empty object if the response could not be parsed
         */
        _parseJsonResponse: function(innerHtmlOrMessage) {
            var response = {};

            try {
                response = qq.parseJson(innerHtmlOrMessage);
            }
            catch (error) {
                log("Error when attempting to parse iframe upload response (" + error.message + ")", "error");
            }

            return response;
        }
    });
};

/* globals qq */
/**
 * Common API exposed to creators of XHR handlers.  This is reused and possibly overriding in some cases by specific
 * XHR upload handlers.
 *
 * @constructor
 */
qq.XhrUploadHandler = function(spec) {
    "use strict";

    var handler = this,
        namespace = spec.options.namespace,
        proxy = spec.proxy,
        chunking = spec.options.chunking,
        resume = spec.options.resume,
        chunkFiles = chunking && spec.options.chunking.enabled && qq.supportedFeatures.chunking,
        resumeEnabled = resume && spec.options.resume.enabled && chunkFiles && qq.supportedFeatures.resume,
        getName = proxy.getName,
        getSize = proxy.getSize,
        getUuid = proxy.getUuid,
        getEndpoint = proxy.getEndpoint,
        getDataByUuid = proxy.getDataByUuid,
        onUuidChanged = proxy.onUuidChanged,
        onProgress = proxy.onProgress,
        log = proxy.log;

    function abort(id) {
        qq.each(handler._getXhrs(id), function(xhrId, xhr) {
            var ajaxRequester = handler._getAjaxRequester(id, xhrId);

            xhr.onreadystatechange = null;
            xhr.upload.onprogress = null;
            xhr.abort();
            ajaxRequester && ajaxRequester.canceled && ajaxRequester.canceled(id);
        });
    }

    qq.extend(this, new qq.UploadHandler(spec));

    qq.override(this, function(super_) {
        return {
            /**
             * Adds File or Blob to the queue
             **/
            add: function(id, blobOrProxy) {
                if (qq.isFile(blobOrProxy) || qq.isBlob(blobOrProxy)) {
                    super_.add(id, {file: blobOrProxy});
                }
                else if (blobOrProxy instanceof qq.BlobProxy) {
                    super_.add(id, {proxy: blobOrProxy});
                }
                else {
                    throw new Error("Passed obj is not a File, Blob, or proxy");
                }

                handler._initTempState(id);
                resumeEnabled && handler._maybePrepareForResume(id);
            },

            expunge: function(id) {
                abort(id);
                handler._maybeDeletePersistedChunkData(id);
                handler._clearXhrs(id);
                super_.expunge(id);
            }
        };
    });

    qq.extend(this, {
        // Clear the cached chunk `Blob` after we are done with it, just in case the `Blob` bytes are stored in memory.
        clearCachedChunk: function(id, chunkIdx) {
            delete handler._getFileState(id).temp.cachedChunks[chunkIdx];
        },

        clearXhr: function(id, chunkIdx) {
            var tempState = handler._getFileState(id).temp;

            if (tempState.xhrs) {
                delete tempState.xhrs[chunkIdx];
            }
            if (tempState.ajaxRequesters) {
                delete tempState.ajaxRequesters[chunkIdx];
            }
        },

        // Called when all chunks have been successfully uploaded.  Expected promissory return type.
        // This defines the default behavior if nothing further is required when all chunks have been uploaded.
        finalizeChunks: function(id, responseParser) {
            var lastChunkIdx = handler._getTotalChunks(id) - 1,
                xhr = handler._getXhr(id, lastChunkIdx);

            if (responseParser) {
                return new qq.Promise().success(responseParser(xhr), xhr);
            }

            return new qq.Promise().success({}, xhr);
        },

        getFile: function(id) {
            return handler.isValid(id) && handler._getFileState(id).file;
        },

        getProxy: function(id) {
            return handler.isValid(id) && handler._getFileState(id).proxy;
        },

        /**
         * @returns {Array} Array of objects containing properties useful to integrators
         * when it is important to determine which files are potentially resumable.
         */
        getResumableFilesData: function() {
            var resumableFilesData = [];

            handler._iterateResumeRecords(function(key, uploadData) {
                handler.moveInProgressToRemaining(null, uploadData.chunking.inProgress,  uploadData.chunking.remaining);

                var data = {
                    name: uploadData.name,
                    remaining: uploadData.chunking.remaining,
                    size: uploadData.size,
                    uuid: uploadData.uuid
                };

                if (uploadData.key) {
                    data.key = uploadData.key;
                }

                resumableFilesData.push(data);
            });

            return resumableFilesData;
        },

        isResumable: function(id) {
            return !!chunking && handler.isValid(id) && !handler._getFileState(id).notResumable;
        },

        moveInProgressToRemaining: function(id, optInProgress, optRemaining) {
            var inProgress = optInProgress || handler._getFileState(id).chunking.inProgress,
                remaining = optRemaining || handler._getFileState(id).chunking.remaining;

            if (inProgress) {
                log(qq.format("Moving these chunks from in-progress {}, to remaining.", JSON.stringify(inProgress)));
                inProgress.reverse();
                qq.each(inProgress, function(idx, chunkIdx) {
                    remaining.unshift(chunkIdx);
                });
                inProgress.length = 0;
            }
        },

        pause: function(id) {
            if (handler.isValid(id)) {
                log(qq.format("Aborting XHR upload for {} '{}' due to pause instruction.", id, getName(id)));
                handler._getFileState(id).paused = true;
                abort(id);
                return true;
            }
        },

        reevaluateChunking: function(id) {
            if (chunking && handler.isValid(id)) {
                var state = handler._getFileState(id),
                    totalChunks,
                    i;

                delete state.chunking;

                state.chunking = {};
                totalChunks = handler._getTotalChunks(id);
                if (totalChunks > 1 || chunking.mandatory) {
                    state.chunking.enabled = true;
                    state.chunking.parts = totalChunks;
                    state.chunking.remaining = [];

                    for (i = 0; i < totalChunks; i++) {
                        state.chunking.remaining.push(i);
                    }

                    handler._initTempState(id);
                }
                else {
                    state.chunking.enabled = false;
                }
            }
        },

        updateBlob: function(id, newBlob) {
            if (handler.isValid(id)) {
                handler._getFileState(id).file = newBlob;
            }
        },

        _clearXhrs: function(id) {
            var tempState = handler._getFileState(id).temp;

            qq.each(tempState.ajaxRequesters, function(chunkId) {
                delete tempState.ajaxRequesters[chunkId];
            });

            qq.each(tempState.xhrs, function(chunkId) {
                delete tempState.xhrs[chunkId];
            });
        },

        /**
         * Creates an XHR instance for this file and stores it in the fileState.
         *
         * @param id File ID
         * @param optChunkIdx The chunk index associated with this XHR, if applicable
         * @returns {XMLHttpRequest}
         */
        _createXhr: function(id, optChunkIdx) {
            return handler._registerXhr(id, optChunkIdx, qq.createXhrInstance());
        },

        _getAjaxRequester: function(id, optChunkIdx) {
            var chunkIdx = optChunkIdx == null ? -1 : optChunkIdx;
            return handler._getFileState(id).temp.ajaxRequesters[chunkIdx];
        },

        _getChunkData: function(id, chunkIndex) {
            var chunkSize = chunking.partSize,
                fileSize = getSize(id),
                fileOrBlob = handler.getFile(id),
                startBytes = chunkSize * chunkIndex,
                endBytes = startBytes + chunkSize >= fileSize ? fileSize : startBytes + chunkSize,
                totalChunks = handler._getTotalChunks(id),
                cachedChunks = this._getFileState(id).temp.cachedChunks,

            // To work around a Webkit GC bug, we must keep each chunk `Blob` in scope until we are done with it.
            // See https://github.com/Widen/fine-uploader/issues/937#issuecomment-41418760
                blob = cachedChunks[chunkIndex] || qq.sliceBlob(fileOrBlob, startBytes, endBytes);

            cachedChunks[chunkIndex] = blob;

            return {
                part: chunkIndex,
                start: startBytes,
                end: endBytes,
                count: totalChunks,
                blob: blob,
                size: endBytes - startBytes
            };
        },

        _getChunkDataForCallback: function(chunkData) {
            return {
                partIndex: chunkData.part,
                startByte: chunkData.start + 1,
                endByte: chunkData.end,
                totalParts: chunkData.count
            };
        },

        /**
         * @param id File ID
         * @returns {string} Identifier for this item that may appear in the browser's local storage
         */
        _getLocalStorageId: function(id) {
            var formatVersion = "5.0",
                name = getName(id),
                size = getSize(id),
                chunkSize = chunking.partSize,
                endpoint = getEndpoint(id);

            return qq.format("qq{}resume{}-{}-{}-{}-{}", namespace, formatVersion, name, size, chunkSize, endpoint);
        },

        _getMimeType: function(id) {
            return handler.getFile(id).type;
        },

        _getPersistableData: function(id) {
            return handler._getFileState(id).chunking;
        },

        /**
         * @param id ID of the associated file
         * @returns {number} Number of parts this file can be divided into, or undefined if chunking is not supported in this UA
         */
        _getTotalChunks: function(id) {
            if (chunking) {
                var fileSize = getSize(id),
                    chunkSize = chunking.partSize;

                return Math.ceil(fileSize / chunkSize);
            }
        },

        _getXhr: function(id, optChunkIdx) {
            var chunkIdx = optChunkIdx == null ? -1 : optChunkIdx;
            return handler._getFileState(id).temp.xhrs[chunkIdx];
        },

        _getXhrs: function(id) {
            return handler._getFileState(id).temp.xhrs;
        },

        // Iterates through all XHR handler-created resume records (in local storage),
        // invoking the passed callback and passing in the key and value of each local storage record.
        _iterateResumeRecords: function(callback) {
            if (resumeEnabled) {
                qq.each(localStorage, function(key, item) {
                    if (key.indexOf(qq.format("qq{}resume", namespace)) === 0) {
                        var uploadData = JSON.parse(item);
                        callback(key, uploadData);
                    }
                });
            }
        },

        _initTempState: function(id) {
            handler._getFileState(id).temp = {
                ajaxRequesters: {},
                chunkProgress: {},
                xhrs: {},
                cachedChunks: {}
            };
        },

        _markNotResumable: function(id) {
            handler._getFileState(id).notResumable = true;
        },

        // Removes a chunked upload record from local storage, if possible.
        // Returns true if the item was removed, false otherwise.
        _maybeDeletePersistedChunkData: function(id) {
            var localStorageId;

            if (resumeEnabled && handler.isResumable(id)) {
                localStorageId = handler._getLocalStorageId(id);

                if (localStorageId && localStorage.getItem(localStorageId)) {
                    localStorage.removeItem(localStorageId);
                    return true;
                }
            }

            return false;
        },

        // If this is a resumable upload, grab the relevant data from storage and items in memory that track this upload
        // so we can pick up from where we left off.
        _maybePrepareForResume: function(id) {
            var state = handler._getFileState(id),
                localStorageId, persistedData;

            // Resume is enabled and possible and this is the first time we've tried to upload this file in this session,
            // so prepare for a resume attempt.
            if (resumeEnabled && state.key === undefined) {
                localStorageId = handler._getLocalStorageId(id);
                persistedData = localStorage.getItem(localStorageId);

                // If we found this item in local storage, maybe we should resume it.
                if (persistedData) {
                    persistedData = JSON.parse(persistedData);

                    // If we found a resume record but we have already handled this file in this session,
                    // don't try to resume it & ensure we don't persist future check data
                    if (getDataByUuid(persistedData.uuid)) {
                        handler._markNotResumable(id);
                    }
                    else {
                        log(qq.format("Identified file with ID {} and name of {} as resumable.", id, getName(id)));

                        onUuidChanged(id, persistedData.uuid);

                        state.key = persistedData.key;
                        state.chunking = persistedData.chunking;
                        state.loaded = persistedData.loaded;
                        state.attemptingResume = true;

                        handler.moveInProgressToRemaining(id);
                    }
                }
            }
        },

        // Persist any data needed to resume this upload in a new session.
        _maybePersistChunkedState: function(id) {
            var state = handler._getFileState(id),
                localStorageId, persistedData;

            // If local storage isn't supported by the browser, or if resume isn't enabled or possible, give up
            if (resumeEnabled && handler.isResumable(id)) {
                localStorageId = handler._getLocalStorageId(id);

                persistedData = {
                    name: getName(id),
                    size: getSize(id),
                    uuid: getUuid(id),
                    key: state.key,
                    chunking: state.chunking,
                    loaded: state.loaded,
                    lastUpdated: Date.now()
                };

                try {
                    localStorage.setItem(localStorageId, JSON.stringify(persistedData));
                }
                catch (error) {
                    log(qq.format("Unable to save resume data for '{}' due to error: '{}'.", id, error.toString()), "warn");
                }
            }
        },

        _registerProgressHandler: function(id, chunkIdx, chunkSize) {
            var xhr = handler._getXhr(id, chunkIdx),
                name = getName(id),
                progressCalculator = {
                    simple: function(loaded, total) {
                        var fileSize = getSize(id);

                        if (loaded === total) {
                            onProgress(id, name, fileSize, fileSize);
                        }
                        else {
                            onProgress(id, name, (loaded >= fileSize ? fileSize - 1 : loaded), fileSize);
                        }
                    },

                    chunked: function(loaded, total) {
                        var chunkProgress = handler._getFileState(id).temp.chunkProgress,
                            totalSuccessfullyLoadedForFile = handler._getFileState(id).loaded,
                            loadedForRequest = loaded,
                            totalForRequest = total,
                            totalFileSize = getSize(id),
                            estActualChunkLoaded = loadedForRequest - (totalForRequest - chunkSize),
                            totalLoadedForFile = totalSuccessfullyLoadedForFile;

                        chunkProgress[chunkIdx] = estActualChunkLoaded;

                        qq.each(chunkProgress, function(chunkIdx, chunkLoaded) {
                            totalLoadedForFile += chunkLoaded;
                        });

                        onProgress(id, name, totalLoadedForFile, totalFileSize);
                    }
                };

            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    /* jshint eqnull: true */
                    var type = chunkSize == null ? "simple" : "chunked";
                    progressCalculator[type](e.loaded, e.total);
                }
            };
        },

        /**
         * Registers an XHR transport instance created elsewhere.
         *
         * @param id ID of the associated file
         * @param optChunkIdx The chunk index associated with this XHR, if applicable
         * @param xhr XMLHttpRequest object instance
         * @param optAjaxRequester `qq.AjaxRequester` associated with this request, if applicable.
         * @returns {XMLHttpRequest}
         */
        _registerXhr: function(id, optChunkIdx, xhr, optAjaxRequester) {
            var xhrsId = optChunkIdx == null ? -1 : optChunkIdx,
                tempState = handler._getFileState(id).temp;

            tempState.xhrs = tempState.xhrs || {};
            tempState.ajaxRequesters = tempState.ajaxRequesters || {};

            tempState.xhrs[xhrsId] = xhr;

            if (optAjaxRequester) {
                tempState.ajaxRequesters[xhrsId] = optAjaxRequester;
            }

            return xhr;
        },

        // Deletes any local storage records that are "expired".
        _removeExpiredChunkingRecords: function() {
            var expirationDays = resume.recordsExpireIn;

            handler._iterateResumeRecords(function(key, uploadData) {
                var expirationDate = new Date(uploadData.lastUpdated);

                // transform updated date into expiration date
                expirationDate.setDate(expirationDate.getDate() + expirationDays);

                if (expirationDate.getTime() <= Date.now()) {
                    log("Removing expired resume record with key " + key);
                    localStorage.removeItem(key);
                }
            });
        },

        /**
         * Determine if the associated file should be chunked.
         *
         * @param id ID of the associated file
         * @returns {*} true if chunking is enabled, possible, and the file can be split into more than 1 part
         */
        _shouldChunkThisFile: function(id) {
            var state = handler._getFileState(id);

            if (!state.chunking) {
                handler.reevaluateChunking(id);
            }

            return state.chunking.enabled;
        }
    });
};

/*globals qq */
/*jshint -W117 */
qq.WindowReceiveMessage = function(o) {
    "use strict";

    var options = {
            log: function(message, level) {}
        },
        callbackWrapperDetachers = {};

    qq.extend(options, o);

    qq.extend(this, {
        receiveMessage: function(id, callback) {
            var onMessageCallbackWrapper = function(event) {
                    callback(event.data);
                };

            if (window.postMessage) {
                callbackWrapperDetachers[id] = qq(window).attach("message", onMessageCallbackWrapper);
            }
            else {
                log("iframe message passing not supported in this browser!", "error");
            }
        },

        stopReceivingMessages: function(id) {
            if (window.postMessage) {
                var detacher = callbackWrapperDetachers[id];
                if (detacher) {
                    detacher();
                }
            }
        }
    });
};

/*globals qq */
/**
 * Defines the public API for FineUploader mode.
 */
(function() {
    "use strict";

    qq.uiPublicApi = {
        addInitialFiles: function(cannedFileList) {
            this._parent.prototype.addInitialFiles.apply(this, arguments);
            this._templating.addCacheToDom();
        },

        clearStoredFiles: function() {
            this._parent.prototype.clearStoredFiles.apply(this, arguments);
            this._templating.clearFiles();
        },

        addExtraDropzone: function(element) {
            this._dnd && this._dnd.setupExtraDropzone(element);
        },

        removeExtraDropzone: function(element) {
            if (this._dnd) {
                return this._dnd.removeDropzone(element);
            }
        },

        getItemByFileId: function(id) {
            if (!this._templating.isHiddenForever(id)) {
                return this._templating.getFileContainer(id);
            }
        },

        reset: function() {
            this._parent.prototype.reset.apply(this, arguments);
            this._templating.reset();

            if (!this._options.button && this._templating.getButton()) {
                this._defaultButtonId = this._createUploadButton({
                    element: this._templating.getButton(),
                    title: this._options.text.fileInputTitle
                }).getButtonId();
            }

            if (this._dnd) {
                this._dnd.dispose();
                this._dnd = this._setupDragAndDrop();
            }

            this._totalFilesInBatch = 0;
            this._filesInBatchAddedToUi = 0;

            this._setupClickAndEditEventHandlers();
        },

        setName: function(id, newName) {
            var formattedFilename = this._options.formatFileName(newName);

            this._parent.prototype.setName.apply(this, arguments);
            this._templating.updateFilename(id, formattedFilename);
        },

        pauseUpload: function(id) {
            var paused = this._parent.prototype.pauseUpload.apply(this, arguments);

            paused && this._templating.uploadPaused(id);
            return paused;
        },

        continueUpload: function(id) {
            var continued = this._parent.prototype.continueUpload.apply(this, arguments);

            continued && this._templating.uploadContinued(id);
            return continued;
        },

        getId: function(fileContainerOrChildEl) {
            return this._templating.getFileId(fileContainerOrChildEl);
        },

        getDropTarget: function(fileId) {
            var file = this.getFile(fileId);

            return file.qqDropTarget;
        }
    };

    /**
     * Defines the private (internal) API for FineUploader mode.
     */
    qq.uiPrivateApi = {
        _getButton: function(buttonId) {
            var button = this._parent.prototype._getButton.apply(this, arguments);

            if (!button) {
                if (buttonId === this._defaultButtonId) {
                    button = this._templating.getButton();
                }
            }

            return button;
        },

        _removeFileItem: function(fileId) {
            this._templating.removeFile(fileId);
        },

        _setupClickAndEditEventHandlers: function() {
            this._fileButtonsClickHandler = qq.FileButtonsClickHandler && this._bindFileButtonsClickEvent();

            // A better approach would be to check specifically for focusin event support by querying the DOM API,
            // but the DOMFocusIn event is not exposed as a property, so we have to resort to UA string sniffing.
            this._focusinEventSupported = !qq.firefox();

            if (this._isEditFilenameEnabled())
            {
                this._filenameClickHandler = this._bindFilenameClickEvent();
                this._filenameInputFocusInHandler = this._bindFilenameInputFocusInEvent();
                this._filenameInputFocusHandler = this._bindFilenameInputFocusEvent();
            }
        },

        _setupDragAndDrop: function() {
            var self = this,
                dropZoneElements = this._options.dragAndDrop.extraDropzones,
                templating = this._templating,
                defaultDropZone = templating.getDropZone();

            defaultDropZone && dropZoneElements.push(defaultDropZone);

            return new qq.DragAndDrop({
                dropZoneElements: dropZoneElements,
                allowMultipleItems: this._options.multiple,
                classes: {
                    dropActive: this._options.classes.dropActive
                },
                callbacks: {
                    processingDroppedFiles: function() {
                        templating.showDropProcessing();
                    },
                    processingDroppedFilesComplete: function(files, targetEl) {
                        templating.hideDropProcessing();

                        qq.each(files, function(idx, file) {
                            file.qqDropTarget = targetEl;
                        });

                        if (files.length) {
                            self.addFiles(files, null, null);
                        }
                    },
                    dropError: function(code, errorData) {
                        self._itemError(code, errorData);
                    },
                    dropLog: function(message, level) {
                        self.log(message, level);
                    }
                }
            });
        },

        _bindFileButtonsClickEvent: function() {
            var self = this;

            return new qq.FileButtonsClickHandler({
                templating: this._templating,

                log: function(message, lvl) {
                    self.log(message, lvl);
                },

                onDeleteFile: function(fileId) {
                    self.deleteFile(fileId);
                },

                onCancel: function(fileId) {
                    self.cancel(fileId);
                },

                onRetry: function(fileId) {
                    self.retry(fileId);
                },

                onPause: function(fileId) {
                    self.pauseUpload(fileId);
                },

                onContinue: function(fileId) {
                    self.continueUpload(fileId);
                },

                onGetName: function(fileId) {
                    return self.getName(fileId);
                }
            });
        },

        _isEditFilenameEnabled: function() {
            /*jshint -W014 */
            return this._templating.isEditFilenamePossible()
                && !this._options.autoUpload
                && qq.FilenameClickHandler
                && qq.FilenameInputFocusHandler
                && qq.FilenameInputFocusHandler;
        },

        _filenameEditHandler: function() {
            var self = this,
                templating = this._templating;

            return {
                templating: templating,
                log: function(message, lvl) {
                    self.log(message, lvl);
                },
                onGetUploadStatus: function(fileId) {
                    return self.getUploads({id: fileId}).status;
                },
                onGetName: function(fileId) {
                    return self.getName(fileId);
                },
                onSetName: function(id, newName) {
                    self.setName(id, newName);
                },
                onEditingStatusChange: function(id, isEditing) {
                    var qqInput = qq(templating.getEditInput(id)),
                        qqFileContainer = qq(templating.getFileContainer(id));

                    if (isEditing) {
                        qqInput.addClass("qq-editing");
                        templating.hideFilename(id);
                        templating.hideEditIcon(id);
                    }
                    else {
                        qqInput.removeClass("qq-editing");
                        templating.showFilename(id);
                        templating.showEditIcon(id);
                    }

                    // Force IE8 and older to repaint
                    qqFileContainer.addClass("qq-temp").removeClass("qq-temp");
                }
            };
        },

        _onUploadStatusChange: function(id, oldStatus, newStatus) {
            this._parent.prototype._onUploadStatusChange.apply(this, arguments);

            if (this._isEditFilenameEnabled()) {
                // Status for a file exists before it has been added to the DOM, so we must be careful here.
                if (this._templating.getFileContainer(id) && newStatus !== qq.status.SUBMITTED) {
                    this._templating.markFilenameEditable(id);
                    this._templating.hideEditIcon(id);
                }
            }

            if (newStatus === qq.status.UPLOAD_RETRYING) {
                this._templating.hideRetry(id);
                this._templating.setStatusText(id);
                qq(this._templating.getFileContainer(id)).removeClass(this._classes.retrying);
            }
            else if (newStatus === qq.status.UPLOAD_FAILED) {
                this._templating.hidePause(id);
            }
        },

        _bindFilenameInputFocusInEvent: function() {
            var spec = qq.extend({}, this._filenameEditHandler());

            return new qq.FilenameInputFocusInHandler(spec);
        },

        _bindFilenameInputFocusEvent: function() {
            var spec = qq.extend({}, this._filenameEditHandler());

            return new qq.FilenameInputFocusHandler(spec);
        },

        _bindFilenameClickEvent: function() {
            var spec = qq.extend({}, this._filenameEditHandler());

            return new qq.FilenameClickHandler(spec);
        },

        _storeForLater: function(id) {
            this._parent.prototype._storeForLater.apply(this, arguments);
            this._templating.hideSpinner(id);
        },

        _onAllComplete: function(successful, failed) {
            this._parent.prototype._onAllComplete.apply(this, arguments);
            this._templating.resetTotalProgress();
        },

        _onSubmit: function(id, name) {
            var file = this.getFile(id);

            if (file && file.qqPath && this._options.dragAndDrop.reportDirectoryPaths) {
                this._paramsStore.addReadOnly(id, {
                    qqpath: file.qqPath
                });
            }

            this._parent.prototype._onSubmit.apply(this, arguments);
            this._addToList(id, name);
        },

        // The file item has been added to the DOM.
        _onSubmitted: function(id) {
            // If the edit filename feature is enabled, mark the filename element as "editable" and the associated edit icon
            if (this._isEditFilenameEnabled()) {
                this._templating.markFilenameEditable(id);
                this._templating.showEditIcon(id);

                // If the focusin event is not supported, we must add a focus handler to the newly create edit filename text input
                if (!this._focusinEventSupported) {
                    this._filenameInputFocusHandler.addHandler(this._templating.getEditInput(id));
                }
            }
        },

        // Update the progress bar & percentage as the file is uploaded
        _onProgress: function(id, name, loaded, total) {
            this._parent.prototype._onProgress.apply(this, arguments);

            this._templating.updateProgress(id, loaded, total);

            if (Math.round(loaded / total * 100) === 100) {
                this._templating.hideCancel(id);
                this._templating.hidePause(id);
                this._templating.hideProgress(id);
                this._templating.setStatusText(id, this._options.text.waitingForResponse);

                // If ~last byte was sent, display total file size
                this._displayFileSize(id);
            }
            else {
                // If still uploading, display percentage - total size is actually the total request(s) size
                this._displayFileSize(id, loaded, total);
            }
        },

        _onTotalProgress: function(loaded, total) {
            this._parent.prototype._onTotalProgress.apply(this, arguments);
            this._templating.updateTotalProgress(loaded, total);
        },

        _onComplete: function(id, name, result, xhr) {
            var parentRetVal = this._parent.prototype._onComplete.apply(this, arguments),
                templating = this._templating,
                fileContainer = templating.getFileContainer(id),
                self = this;

            function completeUpload(result) {
                // If this file is not represented in the templating module, perhaps it was hidden intentionally.
                // If so, don't perform any UI-related tasks related to this file.
                if (!fileContainer) {
                    return;
                }

                templating.setStatusText(id);

                qq(fileContainer).removeClass(self._classes.retrying);
                templating.hideProgress(id);

                if (self.getUploads({id: id}).status !== qq.status.UPLOAD_FAILED) {
                    templating.hideCancel(id);
                }
                templating.hideSpinner(id);

                if (result.success) {
                    self._markFileAsSuccessful(id);
                }
                else {
                    qq(fileContainer).addClass(self._classes.fail);
                    templating.showCancel(id);

                    if (templating.isRetryPossible() && !self._preventRetries[id]) {
                        qq(fileContainer).addClass(self._classes.retryable);
                        templating.showRetry(id);
                    }
                    self._controlFailureTextDisplay(id, result);
                }
            }

            // The parent may need to perform some async operation before we can accurately determine the status of the upload.
            if (parentRetVal instanceof qq.Promise) {
                parentRetVal.done(function(newResult) {
                    completeUpload(newResult);
                });

            }
            else {
                completeUpload(result);
            }

            return parentRetVal;
        },

        _markFileAsSuccessful: function(id) {
            var templating = this._templating;

            if (this._isDeletePossible()) {
                templating.showDeleteButton(id);
            }

            qq(templating.getFileContainer(id)).addClass(this._classes.success);

            this._maybeUpdateThumbnail(id);
        },

        _onUploadPrep: function(id) {
            this._parent.prototype._onUploadPrep.apply(this, arguments);
            this._templating.showSpinner(id);
        },

        _onUpload: function(id, name) {
            var parentRetVal = this._parent.prototype._onUpload.apply(this, arguments);

            this._templating.showSpinner(id);

            return parentRetVal;
        },

        _onUploadChunk: function(id, chunkData) {
            this._parent.prototype._onUploadChunk.apply(this, arguments);

            // Only display the pause button if we have finished uploading at least one chunk
            // & this file can be resumed
            if (chunkData.partIndex > 0 && this._handler.isResumable(id)) {
                this._templating.allowPause(id);
            }
        },

        _onCancel: function(id, name) {
            this._parent.prototype._onCancel.apply(this, arguments);
            this._removeFileItem(id);

            if (this._getNotFinished() === 0) {
                this._templating.resetTotalProgress();
            }
        },

        _onBeforeAutoRetry: function(id) {
            var retryNumForDisplay, maxAuto, retryNote;

            this._parent.prototype._onBeforeAutoRetry.apply(this, arguments);

            this._showCancelLink(id);

            if (this._options.retry.showAutoRetryNote) {
                retryNumForDisplay = this._autoRetries[id];
                maxAuto = this._options.retry.maxAutoAttempts;

                retryNote = this._options.retry.autoRetryNote.replace(/\{retryNum\}/g, retryNumForDisplay);
                retryNote = retryNote.replace(/\{maxAuto\}/g, maxAuto);

                this._templating.setStatusText(id, retryNote);
                qq(this._templating.getFileContainer(id)).addClass(this._classes.retrying);
            }
        },

        //return false if we should not attempt the requested retry
        _onBeforeManualRetry: function(id) {
            if (this._parent.prototype._onBeforeManualRetry.apply(this, arguments)) {
                this._templating.resetProgress(id);
                qq(this._templating.getFileContainer(id)).removeClass(this._classes.fail);
                this._templating.setStatusText(id);
                this._templating.showSpinner(id);
                this._showCancelLink(id);
                return true;
            }
            else {
                qq(this._templating.getFileContainer(id)).addClass(this._classes.retryable);
                this._templating.showRetry(id);
                return false;
            }
        },

        _onSubmitDelete: function(id) {
            var onSuccessCallback = qq.bind(this._onSubmitDeleteSuccess, this);

            this._parent.prototype._onSubmitDelete.call(this, id, onSuccessCallback);
        },

        _onSubmitDeleteSuccess: function(id, uuid, additionalMandatedParams) {
            if (this._options.deleteFile.forceConfirm) {
                this._showDeleteConfirm.apply(this, arguments);
            }
            else {
                this._sendDeleteRequest.apply(this, arguments);
            }
        },

        _onDeleteComplete: function(id, xhr, isError) {
            this._parent.prototype._onDeleteComplete.apply(this, arguments);

            this._templating.hideSpinner(id);

            if (isError) {
                this._templating.setStatusText(id, this._options.deleteFile.deletingFailedText);
                this._templating.showDeleteButton(id);
            }
            else {
                this._removeFileItem(id);
            }
        },

        _sendDeleteRequest: function(id, uuid, additionalMandatedParams) {
            this._templating.hideDeleteButton(id);
            this._templating.showSpinner(id);
            this._templating.setStatusText(id, this._options.deleteFile.deletingStatusText);
            this._deleteHandler.sendDelete.apply(this, arguments);
        },

        _showDeleteConfirm: function(id, uuid, mandatedParams) {
            /*jshint -W004 */
            var fileName = this.getName(id),
                confirmMessage = this._options.deleteFile.confirmMessage.replace(/\{filename\}/g, fileName),
                uuid = this.getUuid(id),
                deleteRequestArgs = arguments,
                self = this,
                retVal;

            retVal = this._options.showConfirm(confirmMessage);

            if (qq.isGenericPromise(retVal)) {
                retVal.then(function() {
                    self._sendDeleteRequest.apply(self, deleteRequestArgs);
                });
            }
            else if (retVal !== false) {
                self._sendDeleteRequest.apply(self, deleteRequestArgs);
            }
        },

        _addToList: function(id, name, canned) {
            var prependData,
                prependIndex = 0,
                dontDisplay = this._handler.isProxied(id) && this._options.scaling.hideScaled,
                record;

            if (this._options.display.prependFiles) {
                if (this._totalFilesInBatch > 1 && this._filesInBatchAddedToUi > 0) {
                    prependIndex = this._filesInBatchAddedToUi - 1;
                }

                prependData = {
                    index: prependIndex
                };
            }

            if (!canned) {
                if (this._options.disableCancelForFormUploads && !qq.supportedFeatures.ajaxUploading) {
                    this._templating.disableCancel();
                }

                // Cancel all existing (previous) files and clear the list if this file is not part of
                // a scaled file group that has already been accepted, or if this file is not part of
                // a scaled file group at all.
                if (!this._options.multiple) {
                    record = this.getUploads({id: id});

                    this._handledProxyGroup = this._handledProxyGroup || record.proxyGroupId;

                    if (record.proxyGroupId !== this._handledProxyGroup || !record.proxyGroupId) {
                        this._handler.cancelAll();
                        this._clearList();
                        this._handledProxyGroup = null;
                    }
                }
            }

            if (canned) {
                this._templating.addFileToCache(id, this._options.formatFileName(name), prependData, dontDisplay);
                this._templating.updateThumbnail(id, this._thumbnailUrls[id], true, this._options.thumbnails.customResizer);
            }
            else {
                this._templating.addFile(id, this._options.formatFileName(name), prependData, dontDisplay);
                this._templating.generatePreview(id, this.getFile(id), this._options.thumbnails.customResizer);
            }

            this._filesInBatchAddedToUi += 1;

            if (canned ||
                (this._options.display.fileSizeOnSubmit && qq.supportedFeatures.ajaxUploading)) {

                this._displayFileSize(id);
            }
        },

        _clearList: function() {
            this._templating.clearFiles();
            this.clearStoredFiles();
        },

        _displayFileSize: function(id, loadedSize, totalSize) {
            var size = this.getSize(id),
                sizeForDisplay = this._formatSize(size);

            if (size >= 0) {
                if (loadedSize !== undefined && totalSize !== undefined) {
                    sizeForDisplay = this._formatProgress(loadedSize, totalSize);
                }

                this._templating.updateSize(id, sizeForDisplay);
            }
        },

        _formatProgress: function(uploadedSize, totalSize) {
            var message = this._options.text.formatProgress;
            function r(name, replacement) { message = message.replace(name, replacement); }

            r("{percent}", Math.round(uploadedSize / totalSize * 100));
            r("{total_size}", this._formatSize(totalSize));
            return message;
        },

        _controlFailureTextDisplay: function(id, response) {
            var mode, responseProperty, failureReason;

            mode = this._options.failedUploadTextDisplay.mode;
            responseProperty = this._options.failedUploadTextDisplay.responseProperty;

            if (mode === "custom") {
                failureReason = response[responseProperty];
                if (!failureReason) {
                    failureReason = this._options.text.failUpload;
                }

                this._templating.setStatusText(id, failureReason);

                if (this._options.failedUploadTextDisplay.enableTooltip) {
                    this._showTooltip(id, failureReason);
                }
            }
            else if (mode === "default") {
                this._templating.setStatusText(id, this._options.text.failUpload);
            }
            else if (mode !== "none") {
                this.log("failedUploadTextDisplay.mode value of '" + mode + "' is not valid", "warn");
            }
        },

        _showTooltip: function(id, text) {
            this._templating.getFileContainer(id).title = text;
        },

        _showCancelLink: function(id) {
            if (!this._options.disableCancelForFormUploads || qq.supportedFeatures.ajaxUploading) {
                this._templating.showCancel(id);
            }
        },

        _itemError: function(code, name, item) {
            var message = this._parent.prototype._itemError.apply(this, arguments);
            this._options.showMessage(message);
        },

        _batchError: function(message) {
            this._parent.prototype._batchError.apply(this, arguments);
            this._options.showMessage(message);
        },

        _setupPastePrompt: function() {
            var self = this;

            this._options.callbacks.onPasteReceived = function() {
                var message = self._options.paste.namePromptMessage,
                    defaultVal = self._options.paste.defaultName;

                return self._options.showPrompt(message, defaultVal);
            };
        },

        _fileOrBlobRejected: function(id, name) {
            this._totalFilesInBatch -= 1;
            this._parent.prototype._fileOrBlobRejected.apply(this, arguments);
        },

        _prepareItemsForUpload: function(items, params, endpoint) {
            this._totalFilesInBatch = items.length;
            this._filesInBatchAddedToUi = 0;
            this._parent.prototype._prepareItemsForUpload.apply(this, arguments);
        },

        _maybeUpdateThumbnail: function(fileId) {
            var thumbnailUrl = this._thumbnailUrls[fileId],
                fileStatus = this.getUploads({id: fileId}).status;

            if (fileStatus !== qq.status.DELETED &&
                (thumbnailUrl ||
                this._options.thumbnails.placeholders.waitUntilResponse ||
                !qq.supportedFeatures.imagePreviews)) {

                // This will replace the "waiting" placeholder with a "preview not available" placeholder
                // if called with a null thumbnailUrl.
                this._templating.updateThumbnail(fileId, thumbnailUrl, this._options.thumbnails.customResizer);
            }
        },

        _addCannedFile: function(sessionData) {
            var id = this._parent.prototype._addCannedFile.apply(this, arguments);

            this._addToList(id, this.getName(id), true);
            this._templating.hideSpinner(id);
            this._templating.hideCancel(id);
            this._markFileAsSuccessful(id);

            return id;
        },

        _setSize: function(id, newSize) {
            this._parent.prototype._setSize.apply(this, arguments);

            this._templating.updateSize(id, this._formatSize(newSize));
        },

        _sessionRequestComplete: function() {
            this._templating.addCacheToDom();
            this._parent.prototype._sessionRequestComplete.apply(this, arguments);
        }
    };
}());

/*globals qq */
/**
 * This defines FineUploader mode, which is a default UI w/ drag & drop uploading.
 */
qq.FineUploader = function(o, namespace) {
    "use strict";

    var self = this;

    // By default this should inherit instance data from FineUploaderBasic, but this can be overridden
    // if the (internal) caller defines a different parent.  The parent is also used by
    // the private and public API functions that need to delegate to a parent function.
    this._parent = namespace ? qq[namespace].FineUploaderBasic : qq.FineUploaderBasic;
    this._parent.apply(this, arguments);

    // Options provided by FineUploader mode
    qq.extend(this._options, {
        element: null,

        button: null,

        listElement: null,

        dragAndDrop: {
            extraDropzones: [],
            reportDirectoryPaths: false
        },

        text: {
            formatProgress: "{percent}% of {total_size}",
            failUpload: "Upload failed",
            waitingForResponse: "Processing...",
            paused: "Paused"
        },

        template: "qq-template",

        classes: {
            retrying: "qq-upload-retrying",
            retryable: "qq-upload-retryable",
            success: "qq-upload-success",
            fail: "qq-upload-fail",
            editable: "qq-editable",
            hide: "qq-hide",
            dropActive: "qq-upload-drop-area-active"
        },

        failedUploadTextDisplay: {
            mode: "default", //default, custom, or none
            responseProperty: "error",
            enableTooltip: true
        },

        messages: {
            tooManyFilesError: "You may only drop one file",
            unsupportedBrowser: "Unrecoverable error - this browser does not permit file uploading of any kind."
        },

        retry: {
            showAutoRetryNote: true,
            autoRetryNote: "Retrying {retryNum}/{maxAuto}..."
        },

        deleteFile: {
            forceConfirm: false,
            confirmMessage: "Are you sure you want to delete {filename}?",
            deletingStatusText: "Deleting...",
            deletingFailedText: "Delete failed"

        },

        display: {
            fileSizeOnSubmit: false,
            prependFiles: false
        },

        paste: {
            promptForName: false,
            namePromptMessage: "Please name this image"
        },

        thumbnails: {
            customResizer: null,
            maxCount: 0,
            placeholders: {
                waitUntilResponse: false,
                notAvailablePath: null,
                waitingPath: null
            },
            timeBetweenThumbs: 750
        },

        scaling: {
            hideScaled: false
        },

        showMessage: function(message) {
            if (self._templating.hasDialog("alert")) {
                return self._templating.showDialog("alert", message);
            }
            else {
                setTimeout(function() {
                    window.alert(message);
                }, 0);
            }
        },

        showConfirm: function(message) {
            if (self._templating.hasDialog("confirm")) {
                return self._templating.showDialog("confirm", message);
            }
            else {
                return window.confirm(message);
            }
        },

        showPrompt: function(message, defaultValue) {
            if (self._templating.hasDialog("prompt")) {
                return self._templating.showDialog("prompt", message, defaultValue);
            }
            else {
                return window.prompt(message, defaultValue);
            }
        }
    }, true);

    // Replace any default options with user defined ones
    qq.extend(this._options, o, true);

    this._templating = new qq.Templating({
        log: qq.bind(this.log, this),
        templateIdOrEl: this._options.template,
        containerEl: this._options.element,
        fileContainerEl: this._options.listElement,
        button: this._options.button,
        imageGenerator: this._imageGenerator,
        classes: {
            hide: this._options.classes.hide,
            editable: this._options.classes.editable
        },
        limits: {
            maxThumbs: this._options.thumbnails.maxCount,
            timeBetweenThumbs: this._options.thumbnails.timeBetweenThumbs
        },
        placeholders: {
            waitUntilUpdate: this._options.thumbnails.placeholders.waitUntilResponse,
            thumbnailNotAvailable: this._options.thumbnails.placeholders.notAvailablePath,
            waitingForThumbnail: this._options.thumbnails.placeholders.waitingPath
        },
        text: this._options.text
    });

    if (this._options.workarounds.ios8SafariUploads && qq.ios800() && qq.iosSafari()) {
        this._templating.renderFailure(this._options.messages.unsupportedBrowserIos8Safari);
    }
    else if (!qq.supportedFeatures.uploading || (this._options.cors.expected && !qq.supportedFeatures.uploadCors)) {
        this._templating.renderFailure(this._options.messages.unsupportedBrowser);
    }
    else {
        this._wrapCallbacks();

        this._templating.render();

        this._classes = this._options.classes;

        if (!this._options.button && this._templating.getButton()) {
            this._defaultButtonId = this._createUploadButton({
                element: this._templating.getButton(),
                title: this._options.text.fileInputTitle
            }).getButtonId();
        }

        this._setupClickAndEditEventHandlers();

        if (qq.DragAndDrop && qq.supportedFeatures.fileDrop) {
            this._dnd = this._setupDragAndDrop();
        }

        if (this._options.paste.targetElement && this._options.paste.promptForName) {
            if (qq.PasteSupport) {
                this._setupPastePrompt();
            }
            else {
                this.log("Paste support module not found.", "error");
            }
        }

        this._totalFilesInBatch = 0;
        this._filesInBatchAddedToUi = 0;
    }
};

// Inherit the base public & private API methods
qq.extend(qq.FineUploader.prototype, qq.basePublicApi);
qq.extend(qq.FineUploader.prototype, qq.basePrivateApi);

// Add the FineUploader/default UI public & private UI methods, which may override some base methods.
qq.extend(qq.FineUploader.prototype, qq.uiPublicApi);
qq.extend(qq.FineUploader.prototype, qq.uiPrivateApi);

/* globals qq */
/* jshint -W065 */
/**
 * Module responsible for rendering all Fine Uploader UI templates.  This module also asserts at least
 * a limited amount of control over the template elements after they are added to the DOM.
 * Wherever possible, this module asserts total control over template elements present in the DOM.
 *
 * @param spec Specification object used to control various templating behaviors
 * @constructor
 */
qq.Templating = function(spec) {
    "use strict";

    var FILE_ID_ATTR = "qq-file-id",
        FILE_CLASS_PREFIX = "qq-file-id-",
        THUMBNAIL_MAX_SIZE_ATTR = "qq-max-size",
        THUMBNAIL_SERVER_SCALE_ATTR = "qq-server-scale",
        // This variable is duplicated in the DnD module since it can function as a standalone as well
        HIDE_DROPZONE_ATTR = "qq-hide-dropzone",
        DROPZPONE_TEXT_ATTR = "qq-drop-area-text",
        IN_PROGRESS_CLASS = "qq-in-progress",
        HIDDEN_FOREVER_CLASS = "qq-hidden-forever",
        fileBatch = {
            content: document.createDocumentFragment(),
            map: {}
        },
        isCancelDisabled = false,
        generatedThumbnails = 0,
        thumbnailQueueMonitorRunning = false,
        thumbGenerationQueue = [],
        thumbnailMaxSize = -1,
        options = {
            log: null,
            limits: {
                maxThumbs: 0,
                timeBetweenThumbs: 750
            },
            templateIdOrEl: "qq-template",
            containerEl: null,
            fileContainerEl: null,
            button: null,
            imageGenerator: null,
            classes: {
                hide: "qq-hide",
                editable: "qq-editable"
            },
            placeholders: {
                waitUntilUpdate: false,
                thumbnailNotAvailable: null,
                waitingForThumbnail: null
            },
            text: {
                paused: "Paused"
            }
        },
        selectorClasses = {
            button: "qq-upload-button-selector",
            alertDialog: "qq-alert-dialog-selector",
            dialogCancelButton: "qq-cancel-button-selector",
            confirmDialog: "qq-confirm-dialog-selector",
            dialogMessage: "qq-dialog-message-selector",
            dialogOkButton: "qq-ok-button-selector",
            promptDialog: "qq-prompt-dialog-selector",
            uploader: "qq-uploader-selector",
            drop: "qq-upload-drop-area-selector",
            list: "qq-upload-list-selector",
            progressBarContainer: "qq-progress-bar-container-selector",
            progressBar: "qq-progress-bar-selector",
            totalProgressBarContainer: "qq-total-progress-bar-container-selector",
            totalProgressBar: "qq-total-progress-bar-selector",
            file: "qq-upload-file-selector",
            spinner: "qq-upload-spinner-selector",
            size: "qq-upload-size-selector",
            cancel: "qq-upload-cancel-selector",
            pause: "qq-upload-pause-selector",
            continueButton: "qq-upload-continue-selector",
            deleteButton: "qq-upload-delete-selector",
            retry: "qq-upload-retry-selector",
            statusText: "qq-upload-status-text-selector",
            editFilenameInput: "qq-edit-filename-selector",
            editNameIcon: "qq-edit-filename-icon-selector",
            dropText: "qq-upload-drop-area-text-selector",
            dropProcessing: "qq-drop-processing-selector",
            dropProcessingSpinner: "qq-drop-processing-spinner-selector",
            thumbnail: "qq-thumbnail-selector"
        },
        previewGeneration = {},
        cachedThumbnailNotAvailableImg = new qq.Promise(),
        cachedWaitingForThumbnailImg = new qq.Promise(),
        log,
        isEditElementsExist,
        isRetryElementExist,
        templateHtml,
        container,
        fileList,
        showThumbnails,
        serverScale,

        // During initialization of the templating module we should cache any
        // placeholder images so we can quickly swap them into the file list on demand.
        // Any placeholder images that cannot be loaded/found are simply ignored.
        cacheThumbnailPlaceholders = function() {
            var notAvailableUrl =  options.placeholders.thumbnailNotAvailable,
                waitingUrl = options.placeholders.waitingForThumbnail,
                spec = {
                    maxSize: thumbnailMaxSize,
                    scale: serverScale
                };

            if (showThumbnails) {
                if (notAvailableUrl) {
                    options.imageGenerator.generate(notAvailableUrl, new Image(), spec).then(
                        function(updatedImg) {
                            cachedThumbnailNotAvailableImg.success(updatedImg);
                        },
                        function() {
                            cachedThumbnailNotAvailableImg.failure();
                            log("Problem loading 'not available' placeholder image at " + notAvailableUrl, "error");
                        }
                    );
                }
                else {
                    cachedThumbnailNotAvailableImg.failure();
                }

                if (waitingUrl) {
                    options.imageGenerator.generate(waitingUrl, new Image(), spec).then(
                        function(updatedImg) {
                            cachedWaitingForThumbnailImg.success(updatedImg);
                        },
                        function() {
                            cachedWaitingForThumbnailImg.failure();
                            log("Problem loading 'waiting for thumbnail' placeholder image at " + waitingUrl, "error");
                        }
                    );
                }
                else {
                    cachedWaitingForThumbnailImg.failure();
                }
            }
        },

        // Displays a "waiting for thumbnail" type placeholder image
        // iff we were able to load it during initialization of the templating module.
        displayWaitingImg = function(thumbnail) {
            var waitingImgPlacement = new qq.Promise();

            cachedWaitingForThumbnailImg.then(function(img) {
                maybeScalePlaceholderViaCss(img, thumbnail);
                /* jshint eqnull:true */
                if (!thumbnail.src) {
                    thumbnail.src = img.src;
                    thumbnail.onload = function() {
                        thumbnail.onload = null;
                        show(thumbnail);
                        waitingImgPlacement.success();
                    };
                }
                else {
                    waitingImgPlacement.success();
                }
            }, function() {
                // In some browsers (such as IE9 and older) an img w/out a src attribute
                // are displayed as "broken" images, so we should just hide the img tag
                // if we aren't going to display the "waiting" placeholder.
                hide(thumbnail);
                waitingImgPlacement.success();
            });

            return waitingImgPlacement;
        },

        generateNewPreview = function(id, blob, spec) {
            var thumbnail = getThumbnail(id);

            log("Generating new thumbnail for " + id);
            blob.qqThumbnailId = id;

            return options.imageGenerator.generate(blob, thumbnail, spec).then(
                function() {
                    generatedThumbnails++;
                    show(thumbnail);
                    previewGeneration[id].success();
                },
                function() {
                    previewGeneration[id].failure();

                    // Display the "not available" placeholder img only if we are
                    // not expecting a thumbnail at a later point, such as in a server response.
                    if (!options.placeholders.waitUntilUpdate) {
                        maybeSetDisplayNotAvailableImg(id, thumbnail);
                    }
                });
        },

        generateNextQueuedPreview = function() {
            if (thumbGenerationQueue.length) {
                thumbnailQueueMonitorRunning = true;

                var queuedThumbRequest = thumbGenerationQueue.shift();

                if (queuedThumbRequest.update) {
                    processUpdateQueuedPreviewRequest(queuedThumbRequest);
                }
                else {
                    processNewQueuedPreviewRequest(queuedThumbRequest);
                }
            }
            else {
                thumbnailQueueMonitorRunning = false;
            }
        },

        getCancel = function(id) {
            return getTemplateEl(getFile(id), selectorClasses.cancel);
        },

        getContinue = function(id) {
            return getTemplateEl(getFile(id), selectorClasses.continueButton);
        },

        getDialog = function(type) {
            return getTemplateEl(container, selectorClasses[type + "Dialog"]);
        },

        getDelete = function(id) {
            return getTemplateEl(getFile(id), selectorClasses.deleteButton);
        },

        getDropProcessing = function() {
            return getTemplateEl(container, selectorClasses.dropProcessing);
        },

        getEditIcon = function(id) {
            return getTemplateEl(getFile(id), selectorClasses.editNameIcon);
        },

        getFile = function(id) {
            return fileBatch.map[id] || qq(fileList).getFirstByClass(FILE_CLASS_PREFIX + id);
        },

        getFilename = function(id) {
            return getTemplateEl(getFile(id), selectorClasses.file);
        },

        getPause = function(id) {
            return getTemplateEl(getFile(id), selectorClasses.pause);
        },

        getProgress = function(id) {
            /* jshint eqnull:true */
            // Total progress bar
            if (id == null) {
                return getTemplateEl(container, selectorClasses.totalProgressBarContainer) ||
                    getTemplateEl(container, selectorClasses.totalProgressBar);
            }

            // Per-file progress bar
            return getTemplateEl(getFile(id), selectorClasses.progressBarContainer) ||
                getTemplateEl(getFile(id), selectorClasses.progressBar);
        },

        getRetry = function(id) {
            return getTemplateEl(getFile(id), selectorClasses.retry);
        },

        getSize = function(id) {
            return getTemplateEl(getFile(id), selectorClasses.size);
        },

        getSpinner = function(id) {
            return getTemplateEl(getFile(id), selectorClasses.spinner);
        },

        getTemplateEl = function(context, cssClass) {
            return context && qq(context).getFirstByClass(cssClass);
        },

        getThumbnail = function(id) {
            return showThumbnails && getTemplateEl(getFile(id), selectorClasses.thumbnail);
        },

        hide = function(el) {
            el && qq(el).addClass(options.classes.hide);
        },

        // Ensures a placeholder image does not exceed any max size specified
        // via `style` attribute properties iff <canvas> was not used to scale
        // the placeholder AND the target <img> doesn't already have these `style` attribute properties set.
        maybeScalePlaceholderViaCss = function(placeholder, thumbnail) {
            var maxWidth = placeholder.style.maxWidth,
                maxHeight = placeholder.style.maxHeight;

            if (maxHeight && maxWidth && !thumbnail.style.maxWidth && !thumbnail.style.maxHeight) {
                qq(thumbnail).css({
                    maxWidth: maxWidth,
                    maxHeight: maxHeight
                });
            }
        },

        // Displays a "thumbnail not available" type placeholder image
        // iff we were able to load this placeholder during initialization
        // of the templating module or after preview generation has failed.
        maybeSetDisplayNotAvailableImg = function(id, thumbnail) {
            var previewing = previewGeneration[id] || new qq.Promise().failure(),
                notAvailableImgPlacement = new qq.Promise();

            cachedThumbnailNotAvailableImg.then(function(img) {
                previewing.then(
                    function() {
                        notAvailableImgPlacement.success();
                    },
                    function() {
                        maybeScalePlaceholderViaCss(img, thumbnail);

                        thumbnail.onload = function() {
                            thumbnail.onload = null;
                            notAvailableImgPlacement.success();
                        };

                        thumbnail.src = img.src;
                        show(thumbnail);
                    }
                );
            });

            return notAvailableImgPlacement;
        },

        /**
         * Grabs the HTML from the script tag holding the template markup.  This function will also adjust
         * some internally-tracked state variables based on the contents of the template.
         * The template is filtered so that irrelevant elements (such as the drop zone if DnD is not supported)
         * are omitted from the DOM.  Useful errors will be thrown if the template cannot be parsed.
         *
         * @returns {{template: *, fileTemplate: *}} HTML for the top-level file items templates
         */
        parseAndGetTemplate = function() {
            var scriptEl,
                scriptHtml,
                fileListNode,
                tempTemplateEl,
                fileListHtml,
                defaultButton,
                dropArea,
                thumbnail,
                dropProcessing,
                dropTextEl,
                uploaderEl;

            log("Parsing template");

            /*jshint -W116*/
            if (options.templateIdOrEl == null) {
                throw new Error("You MUST specify either a template element or ID!");
            }

            // Grab the contents of the script tag holding the template.
            if (qq.isString(options.templateIdOrEl)) {
                scriptEl = document.getElementById(options.templateIdOrEl);

                if (scriptEl === null) {
                    throw new Error(qq.format("Cannot find template script at ID '{}'!", options.templateIdOrEl));
                }

                scriptHtml = scriptEl.innerHTML;
            }
            else {
                if (options.templateIdOrEl.innerHTML === undefined) {
                    throw new Error("You have specified an invalid value for the template option!  " +
                        "It must be an ID or an Element.");
                }

                scriptHtml = options.templateIdOrEl.innerHTML;
            }

            scriptHtml = qq.trimStr(scriptHtml);
            tempTemplateEl = document.createElement("div");
            tempTemplateEl.appendChild(qq.toElement(scriptHtml));
            uploaderEl = qq(tempTemplateEl).getFirstByClass(selectorClasses.uploader);

            // Don't include the default template button in the DOM
            // if an alternate button container has been specified.
            if (options.button) {
                defaultButton = qq(tempTemplateEl).getFirstByClass(selectorClasses.button);
                if (defaultButton) {
                    qq(defaultButton).remove();
                }
            }

            // Omit the drop processing element from the DOM if DnD is not supported by the UA,
            // or the drag and drop module is not found.
            // NOTE: We are consciously not removing the drop zone if the UA doesn't support DnD
            // to support layouts where the drop zone is also a container for visible elements,
            // such as the file list.
            if (!qq.DragAndDrop || !qq.supportedFeatures.fileDrop) {
                dropProcessing = qq(tempTemplateEl).getFirstByClass(selectorClasses.dropProcessing);
                if (dropProcessing) {
                    qq(dropProcessing).remove();
                }
            }

            dropArea = qq(tempTemplateEl).getFirstByClass(selectorClasses.drop);

            // If DnD is not available then remove
            // it from the DOM as well.
            if (dropArea && !qq.DragAndDrop) {
                log("DnD module unavailable.", "info");
                qq(dropArea).remove();
            }

            if (!qq.supportedFeatures.fileDrop) {
                // don't display any "drop files to upload" background text
                uploaderEl.removeAttribute(DROPZPONE_TEXT_ATTR);

                if (dropArea && qq(dropArea).hasAttribute(HIDE_DROPZONE_ATTR)) {
                    // If there is a drop area defined in the template, and the current UA doesn't support DnD,
                    // and the drop area is marked as "hide before enter", ensure it is hidden as the DnD module
                    // will not do this (since we will not be loading the DnD module)
                    qq(dropArea).css({
                        display: "none"
                    });
                }
            }
            else if (qq(uploaderEl).hasAttribute(DROPZPONE_TEXT_ATTR) && dropArea) {
                dropTextEl = qq(dropArea).getFirstByClass(selectorClasses.dropText);
                dropTextEl && qq(dropTextEl).remove();
            }

            // Ensure the `showThumbnails` flag is only set if the thumbnail element
            // is present in the template AND the current UA is capable of generating client-side previews.
            thumbnail = qq(tempTemplateEl).getFirstByClass(selectorClasses.thumbnail);
            if (!showThumbnails) {
                thumbnail && qq(thumbnail).remove();
            }
            else if (thumbnail) {
                thumbnailMaxSize = parseInt(thumbnail.getAttribute(THUMBNAIL_MAX_SIZE_ATTR));
                // Only enforce max size if the attr value is non-zero
                thumbnailMaxSize = thumbnailMaxSize > 0 ? thumbnailMaxSize : null;

                serverScale = qq(thumbnail).hasAttribute(THUMBNAIL_SERVER_SCALE_ATTR);
            }
            showThumbnails = showThumbnails && thumbnail;

            isEditElementsExist = qq(tempTemplateEl).getByClass(selectorClasses.editFilenameInput).length > 0;
            isRetryElementExist = qq(tempTemplateEl).getByClass(selectorClasses.retry).length > 0;

            fileListNode = qq(tempTemplateEl).getFirstByClass(selectorClasses.list);
            /*jshint -W116*/
            if (fileListNode == null) {
                throw new Error("Could not find the file list container in the template!");
            }

            fileListHtml = fileListNode.innerHTML;
            fileListNode.innerHTML = "";

            // We must call `createElement` in IE8 in order to target and hide any <dialog> via CSS
            if (tempTemplateEl.getElementsByTagName("DIALOG").length) {
                document.createElement("dialog");
            }

            log("Template parsing complete");

            return {
                template: qq.trimStr(tempTemplateEl.innerHTML),
                fileTemplate: qq.trimStr(fileListHtml)
            };
        },

        prependFile = function(el, index, fileList) {
            var parentEl = fileList,
                beforeEl = parentEl.firstChild;

            if (index > 0) {
                beforeEl = qq(parentEl).children()[index].nextSibling;

            }

            parentEl.insertBefore(el, beforeEl);
        },

        processNewQueuedPreviewRequest = function(queuedThumbRequest) {
            var id = queuedThumbRequest.id,
                optFileOrBlob = queuedThumbRequest.optFileOrBlob,
                relatedThumbnailId = optFileOrBlob && optFileOrBlob.qqThumbnailId,
                thumbnail = getThumbnail(id),
                spec = {
                    customResizeFunction: queuedThumbRequest.customResizeFunction,
                    maxSize: thumbnailMaxSize,
                    orient: true,
                    scale: true
                };

            if (qq.supportedFeatures.imagePreviews) {
                if (thumbnail) {
                    if (options.limits.maxThumbs && options.limits.maxThumbs <= generatedThumbnails) {
                        maybeSetDisplayNotAvailableImg(id, thumbnail);
                        generateNextQueuedPreview();
                    }
                    else {
                        displayWaitingImg(thumbnail).done(function() {
                            previewGeneration[id] = new qq.Promise();

                            previewGeneration[id].done(function() {
                                setTimeout(generateNextQueuedPreview, options.limits.timeBetweenThumbs);
                            });

                            /* jshint eqnull: true */
                            // If we've already generated an <img> for this file, use the one that exists,
                            // don't waste resources generating a new one.
                            if (relatedThumbnailId != null) {
                                useCachedPreview(id, relatedThumbnailId);
                            }
                            else {
                                generateNewPreview(id, optFileOrBlob, spec);
                            }
                        });
                    }
                }
                // File element in template may have been removed, so move on to next item in queue
                else {
                    generateNextQueuedPreview();
                }
            }
            else if (thumbnail) {
                displayWaitingImg(thumbnail);
                generateNextQueuedPreview();
            }
        },

        processUpdateQueuedPreviewRequest = function(queuedThumbRequest) {
            var id = queuedThumbRequest.id,
                thumbnailUrl = queuedThumbRequest.thumbnailUrl,
                showWaitingImg = queuedThumbRequest.showWaitingImg,
                thumbnail = getThumbnail(id),
                spec = {
                    customResizeFunction: queuedThumbRequest.customResizeFunction,
                    scale: serverScale,
                    maxSize: thumbnailMaxSize
                };

            if (thumbnail) {
                if (thumbnailUrl) {
                    if (options.limits.maxThumbs && options.limits.maxThumbs <= generatedThumbnails) {
                        maybeSetDisplayNotAvailableImg(id, thumbnail);
                        generateNextQueuedPreview();
                    }
                    else {
                        if (showWaitingImg) {
                            displayWaitingImg(thumbnail);
                        }

                        return options.imageGenerator.generate(thumbnailUrl, thumbnail, spec).then(
                            function() {
                                show(thumbnail);
                                generatedThumbnails++;
                                setTimeout(generateNextQueuedPreview, options.limits.timeBetweenThumbs);
                            },

                            function() {
                                maybeSetDisplayNotAvailableImg(id, thumbnail);
                                setTimeout(generateNextQueuedPreview, options.limits.timeBetweenThumbs);
                            }
                        );
                    }
                }
                else {
                    maybeSetDisplayNotAvailableImg(id, thumbnail);
                    generateNextQueuedPreview();
                }
            }
        },

        setProgressBarWidth = function(id, percent) {
            var bar = getProgress(id),
                /* jshint eqnull:true */
                progressBarSelector = id == null ? selectorClasses.totalProgressBar : selectorClasses.progressBar;

            if (bar && !qq(bar).hasClass(progressBarSelector)) {
                bar = qq(bar).getFirstByClass(progressBarSelector);
            }

            if (bar) {
                qq(bar).css({width: percent + "%"});
                bar.setAttribute("aria-valuenow", percent);
            }
        },

        show = function(el) {
            el && qq(el).removeClass(options.classes.hide);
        },

        useCachedPreview = function(targetThumbnailId, cachedThumbnailId) {
            var targetThumbnail = getThumbnail(targetThumbnailId),
                cachedThumbnail = getThumbnail(cachedThumbnailId);

            log(qq.format("ID {} is the same file as ID {}.  Will use generated thumbnail from ID {} instead.", targetThumbnailId, cachedThumbnailId, cachedThumbnailId));

            // Generation of the related thumbnail may still be in progress, so, wait until it is done.
            previewGeneration[cachedThumbnailId].then(function() {
                generatedThumbnails++;
                previewGeneration[targetThumbnailId].success();
                log(qq.format("Now using previously generated thumbnail created for ID {} on ID {}.", cachedThumbnailId, targetThumbnailId));
                targetThumbnail.src = cachedThumbnail.src;
                show(targetThumbnail);
            },
            function() {
                previewGeneration[targetThumbnailId].failure();
                if (!options.placeholders.waitUntilUpdate) {
                    maybeSetDisplayNotAvailableImg(targetThumbnailId, targetThumbnail);
                }
            });
        };

    qq.extend(options, spec);
    log = options.log;

    // No need to worry about conserving CPU or memory on older browsers,
    // since there is no ability to preview, and thumbnail display is primitive and quick.
    if (!qq.supportedFeatures.imagePreviews) {
        options.limits.timeBetweenThumbs = 0;
        options.limits.maxThumbs = 0;
    }

    container = options.containerEl;
    showThumbnails = options.imageGenerator !== undefined;
    templateHtml = parseAndGetTemplate();

    cacheThumbnailPlaceholders();

    qq.extend(this, {
        render: function() {
            log("Rendering template in DOM.");

            generatedThumbnails = 0;

            container.innerHTML = templateHtml.template;
            hide(getDropProcessing());
            this.hideTotalProgress();
            fileList = options.fileContainerEl || getTemplateEl(container, selectorClasses.list);

            log("Template rendering complete");
        },

        renderFailure: function(message) {
            var cantRenderEl = qq.toElement(message);
            container.innerHTML = "";
            container.appendChild(cantRenderEl);
        },

        reset: function() {
            this.render();
        },

        clearFiles: function() {
            fileList.innerHTML = "";
        },

        disableCancel: function() {
            isCancelDisabled = true;
        },

        addFile: function(id, name, prependInfo, hideForever, batch) {
            var fileEl = qq.toElement(templateHtml.fileTemplate),
                fileNameEl = getTemplateEl(fileEl, selectorClasses.file),
                uploaderEl = getTemplateEl(container, selectorClasses.uploader),
                fileContainer = batch ? fileBatch.content : fileList,
                thumb;

            if (batch) {
                fileBatch.map[id] = fileEl;
            }

            qq(fileEl).addClass(FILE_CLASS_PREFIX + id);
            uploaderEl.removeAttribute(DROPZPONE_TEXT_ATTR);

            if (fileNameEl) {
                qq(fileNameEl).setText(name);
                fileNameEl.setAttribute("title", name);
            }

            fileEl.setAttribute(FILE_ID_ATTR, id);

            if (prependInfo) {
                prependFile(fileEl, prependInfo.index, fileContainer);
            }
            else {
                fileContainer.appendChild(fileEl);
            }

            if (hideForever) {
                fileEl.style.display = "none";
                qq(fileEl).addClass(HIDDEN_FOREVER_CLASS);
            }
            else {
                hide(getProgress(id));
                hide(getSize(id));
                hide(getDelete(id));
                hide(getRetry(id));
                hide(getPause(id));
                hide(getContinue(id));

                if (isCancelDisabled) {
                    this.hideCancel(id);
                }

                thumb = getThumbnail(id);
                if (thumb && !thumb.src) {
                    cachedWaitingForThumbnailImg.then(function(waitingImg) {
                        thumb.src = waitingImg.src;
                        if (waitingImg.style.maxHeight && waitingImg.style.maxWidth) {
                            qq(thumb).css({
                                maxHeight: waitingImg.style.maxHeight,
                                maxWidth: waitingImg.style.maxWidth
                            });
                        }

                        show(thumb);
                    });
                }
            }
        },

        addFileToCache: function(id, name, prependInfo, hideForever) {
            this.addFile(id, name, prependInfo, hideForever, true);
        },

        addCacheToDom: function() {
            fileList.appendChild(fileBatch.content);
            fileBatch.content = document.createDocumentFragment();
            fileBatch.map = {};
        },

        removeFile: function(id) {
            qq(getFile(id)).remove();
        },

        getFileId: function(el) {
            var currentNode = el;

            if (currentNode) {
                /*jshint -W116*/
                while (currentNode.getAttribute(FILE_ID_ATTR) == null) {
                    currentNode = currentNode.parentNode;
                }

                return parseInt(currentNode.getAttribute(FILE_ID_ATTR));
            }
        },

        getFileList: function() {
            return fileList;
        },

        markFilenameEditable: function(id) {
            var filename = getFilename(id);

            filename && qq(filename).addClass(options.classes.editable);
        },

        updateFilename: function(id, name) {
            var filenameEl = getFilename(id);

            if (filenameEl) {
                qq(filenameEl).setText(name);
                filenameEl.setAttribute("title", name);
            }
        },

        hideFilename: function(id) {
            hide(getFilename(id));
        },

        showFilename: function(id) {
            show(getFilename(id));
        },

        isFileName: function(el) {
            return qq(el).hasClass(selectorClasses.file);
        },

        getButton: function() {
            return options.button || getTemplateEl(container, selectorClasses.button);
        },

        hideDropProcessing: function() {
            hide(getDropProcessing());
        },

        showDropProcessing: function() {
            show(getDropProcessing());
        },

        getDropZone: function() {
            return getTemplateEl(container, selectorClasses.drop);
        },

        isEditFilenamePossible: function() {
            return isEditElementsExist;
        },

        hideRetry: function(id) {
            hide(getRetry(id));
        },

        isRetryPossible: function() {
            return isRetryElementExist;
        },

        showRetry: function(id) {
            show(getRetry(id));
        },

        getFileContainer: function(id) {
            return getFile(id);
        },

        showEditIcon: function(id) {
            var icon = getEditIcon(id);

            icon && qq(icon).addClass(options.classes.editable);
        },

        isHiddenForever: function(id) {
            return qq(getFile(id)).hasClass(HIDDEN_FOREVER_CLASS);
        },

        hideEditIcon: function(id) {
            var icon = getEditIcon(id);

            icon && qq(icon).removeClass(options.classes.editable);
        },

        isEditIcon: function(el) {
            return qq(el).hasClass(selectorClasses.editNameIcon, true);
        },

        getEditInput: function(id) {
            return getTemplateEl(getFile(id), selectorClasses.editFilenameInput);
        },

        isEditInput: function(el) {
            return qq(el).hasClass(selectorClasses.editFilenameInput, true);
        },

        updateProgress: function(id, loaded, total) {
            var bar = getProgress(id),
                percent;

            if (bar && total > 0) {
                percent = Math.round(loaded / total * 100);

                if (percent === 100) {
                    hide(bar);
                }
                else {
                    show(bar);
                }

                setProgressBarWidth(id, percent);
            }
        },

        updateTotalProgress: function(loaded, total) {
            this.updateProgress(null, loaded, total);
        },

        hideProgress: function(id) {
            var bar = getProgress(id);

            bar && hide(bar);
        },

        hideTotalProgress: function() {
            this.hideProgress();
        },

        resetProgress: function(id) {
            setProgressBarWidth(id, 0);
            this.hideTotalProgress(id);
        },

        resetTotalProgress: function() {
            this.resetProgress();
        },

        showCancel: function(id) {
            if (!isCancelDisabled) {
                var cancel = getCancel(id);

                cancel && qq(cancel).removeClass(options.classes.hide);
            }
        },

        hideCancel: function(id) {
            hide(getCancel(id));
        },

        isCancel: function(el)  {
            return qq(el).hasClass(selectorClasses.cancel, true);
        },

        allowPause: function(id) {
            show(getPause(id));
            hide(getContinue(id));
        },

        uploadPaused: function(id) {
            this.setStatusText(id, options.text.paused);
            this.allowContinueButton(id);
            hide(getSpinner(id));
        },

        hidePause: function(id) {
            hide(getPause(id));
        },

        isPause: function(el) {
            return qq(el).hasClass(selectorClasses.pause, true);
        },

        isContinueButton: function(el) {
            return qq(el).hasClass(selectorClasses.continueButton, true);
        },

        allowContinueButton: function(id) {
            show(getContinue(id));
            hide(getPause(id));
        },

        uploadContinued: function(id) {
            this.setStatusText(id, "");
            this.allowPause(id);
            show(getSpinner(id));
        },

        showDeleteButton: function(id) {
            show(getDelete(id));
        },

        hideDeleteButton: function(id) {
            hide(getDelete(id));
        },

        isDeleteButton: function(el) {
            return qq(el).hasClass(selectorClasses.deleteButton, true);
        },

        isRetry: function(el) {
            return qq(el).hasClass(selectorClasses.retry, true);
        },

        updateSize: function(id, text) {
            var size = getSize(id);

            if (size) {
                show(size);
                qq(size).setText(text);
            }
        },

        setStatusText: function(id, text) {
            var textEl = getTemplateEl(getFile(id), selectorClasses.statusText);

            if (textEl) {
                /*jshint -W116*/
                if (text == null) {
                    qq(textEl).clearText();
                }
                else {
                    qq(textEl).setText(text);
                }
            }
        },

        hideSpinner: function(id) {
            qq(getFile(id)).removeClass(IN_PROGRESS_CLASS);
            hide(getSpinner(id));
        },

        showSpinner: function(id) {
            qq(getFile(id)).addClass(IN_PROGRESS_CLASS);
            show(getSpinner(id));
        },

        generatePreview: function(id, optFileOrBlob, customResizeFunction) {
            if (!this.isHiddenForever(id)) {
                thumbGenerationQueue.push({id: id, customResizeFunction: customResizeFunction, optFileOrBlob: optFileOrBlob});
                !thumbnailQueueMonitorRunning && generateNextQueuedPreview();
            }
        },

        updateThumbnail: function(id, thumbnailUrl, showWaitingImg, customResizeFunction) {
            if (!this.isHiddenForever(id)) {
                thumbGenerationQueue.push({customResizeFunction: customResizeFunction, update: true, id: id, thumbnailUrl: thumbnailUrl, showWaitingImg: showWaitingImg});
                !thumbnailQueueMonitorRunning && generateNextQueuedPreview();
            }
        },

        hasDialog: function(type) {
            return qq.supportedFeatures.dialogElement && !!getDialog(type);
        },

        showDialog: function(type, message, defaultValue) {
            var dialog = getDialog(type),
                messageEl = getTemplateEl(dialog, selectorClasses.dialogMessage),
                inputEl = dialog.getElementsByTagName("INPUT")[0],
                cancelBtn = getTemplateEl(dialog, selectorClasses.dialogCancelButton),
                okBtn = getTemplateEl(dialog, selectorClasses.dialogOkButton),
                promise = new qq.Promise(),

                closeHandler = function() {
                    cancelBtn.removeEventListener("click", cancelClickHandler);
                    okBtn && okBtn.removeEventListener("click", okClickHandler);
                    promise.failure();
                },

                cancelClickHandler = function() {
                    cancelBtn.removeEventListener("click", cancelClickHandler);
                    dialog.close();
                },

                okClickHandler = function() {
                    dialog.removeEventListener("close", closeHandler);
                    okBtn.removeEventListener("click", okClickHandler);
                    dialog.close();

                    promise.success(inputEl && inputEl.value);
                };

            dialog.addEventListener("close", closeHandler);
            cancelBtn.addEventListener("click", cancelClickHandler);
            okBtn && okBtn.addEventListener("click", okClickHandler);

            if (inputEl) {
                inputEl.value = defaultValue;
            }
            messageEl.textContent = message;

            dialog.showModal();

            return promise;
        }
    });
};

/*globals qq*/
/**
 * Upload handler used that assumes the current user agent does not have any support for the
 * File API, and, therefore, makes use of iframes and forms to submit the files directly to
 * a generic server.
 *
 * @param options Options passed from the base handler
 * @param proxy Callbacks & methods used to query for or push out data/changes
 */
qq.traditional = qq.traditional || {};
qq.traditional.FormUploadHandler = function(options, proxy) {
    "use strict";

    var handler = this,
        getName = proxy.getName,
        getUuid = proxy.getUuid,
        log = proxy.log;

    /**
     * Returns json object received by iframe from server.
     */
    function getIframeContentJson(id, iframe) {
        /*jshint evil: true*/

        var response, doc, innerHtml;

        //IE may throw an "access is denied" error when attempting to access contentDocument on the iframe in some cases
        try {
            // iframe.contentWindow.document - for IE<7
            doc = iframe.contentDocument || iframe.contentWindow.document;
            innerHtml = doc.body.innerHTML;

            log("converting iframe's innerHTML to JSON");
            log("innerHTML = " + innerHtml);
            //plain text response may be wrapped in <pre> tag
            if (innerHtml && innerHtml.match(/^<pre/i)) {
                innerHtml = doc.body.firstChild.firstChild.nodeValue;
            }

            response = handler._parseJsonResponse(innerHtml);
        }
        catch (error) {
            log("Error when attempting to parse form upload response (" + error.message + ")", "error");
            response = {success: false};
        }

        return response;
    }

    /**
     * Creates form, that will be submitted to iframe
     */
    function createForm(id, iframe) {
        var params = options.paramsStore.get(id),
            method = options.method.toLowerCase() === "get" ? "GET" : "POST",
            endpoint = options.endpointStore.get(id),
            name = getName(id);

        params[options.uuidName] = getUuid(id);
        params[options.filenameParam] = name;

        return handler._initFormForUpload({
            method: method,
            endpoint: endpoint,
            params: params,
            paramsInBody: options.paramsInBody,
            targetName: iframe.name
        });
    }

    this.uploadFile = function(id) {
        var input = handler.getInput(id),
            iframe = handler._createIframe(id),
            promise = new qq.Promise(),
            form;

        form = createForm(id, iframe);
        form.appendChild(input);

        handler._attachLoadEvent(iframe, function(responseFromMessage) {
            log("iframe loaded");

            var response = responseFromMessage ? responseFromMessage : getIframeContentJson(id, iframe);

            handler._detachLoadEvent(id);

            //we can't remove an iframe if the iframe doesn't belong to the same domain
            if (!options.cors.expected) {
                qq(iframe).remove();
            }

            if (response.success) {
                promise.success(response);
            }
            else {
                promise.failure(response);
            }
        });

        log("Sending upload request for " + id);
        form.submit();
        qq(form).remove();

        return promise;
    };

    qq.extend(this, new qq.FormUploadHandler({
        options: {
            isCors: options.cors.expected,
            inputName: options.inputName
        },

        proxy: {
            onCancel: options.onCancel,
            getName: getName,
            getUuid: getUuid,
            log: log
        }
    }));
};

/*globals qq*/
/**
 * Upload handler used to upload to traditional endpoints.  It depends on File API support, and, therefore,
 * makes use of `XMLHttpRequest` level 2 to upload `File`s and `Blob`s to a generic server.
 *
 * @param spec Options passed from the base handler
 * @param proxy Callbacks & methods used to query for or push out data/changes
 */
qq.traditional = qq.traditional || {};
qq.traditional.XhrUploadHandler = function(spec, proxy) {
    "use strict";

    var handler = this,
        getName = proxy.getName,
        getSize = proxy.getSize,
        getUuid = proxy.getUuid,
        log = proxy.log,
        multipart = spec.forceMultipart || spec.paramsInBody,

        addChunkingSpecificParams = function(id, params, chunkData) {
            var size = getSize(id),
                name = getName(id);

            params[spec.chunking.paramNames.partIndex] = chunkData.part;
            params[spec.chunking.paramNames.partByteOffset] = chunkData.start;
            params[spec.chunking.paramNames.chunkSize] = chunkData.size;
            params[spec.chunking.paramNames.totalParts] = chunkData.count;
            params[spec.totalFileSizeName] = size;

            /**
             * When a Blob is sent in a multipart request, the filename value in the content-disposition header is either "blob"
             * or an empty string.  So, we will need to include the actual file name as a param in this case.
             */
            if (multipart) {
                params[spec.filenameParam] = name;
            }
        },

        allChunksDoneRequester = new qq.traditional.AllChunksDoneAjaxRequester({
            cors: spec.cors,
            endpoint: spec.chunking.success.endpoint,
            log: log
        }),

        createReadyStateChangedHandler = function(id, xhr) {
            var promise = new qq.Promise();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    var result = onUploadOrChunkComplete(id, xhr);

                    if (result.success) {
                        promise.success(result.response, xhr);
                    }
                    else {
                        promise.failure(result.response, xhr);
                    }
                }
            };

            return promise;
        },

        getChunksCompleteParams = function(id) {
            var params = spec.paramsStore.get(id),
                name = getName(id),
                size = getSize(id);

            params[spec.uuidName] = getUuid(id);
            params[spec.filenameParam] = name;
            params[spec.totalFileSizeName] = size;
            params[spec.chunking.paramNames.totalParts] = handler._getTotalChunks(id);

            return params;
        },

        isErrorUploadResponse = function(xhr, response) {
            return qq.indexOf([200, 201, 202, 203, 204], xhr.status) < 0 ||
                !response.success ||
                response.reset;
        },

        onUploadOrChunkComplete = function(id, xhr) {
            var response;

            log("xhr - server response received for " + id);
            log("responseText = " + xhr.responseText);

            response = parseResponse(true, xhr);

            return {
                success: !isErrorUploadResponse(xhr, response),
                response: response
            };
        },

        // If this is an upload response, we require a JSON payload, otherwise, it is optional.
        parseResponse = function(upload, xhr) {
            var response = {};

            try {
                log(qq.format("Received response status {} with body: {}", xhr.status, xhr.responseText));
                response = qq.parseJson(xhr.responseText);
            }
            catch (error) {
                upload && log("Error when attempting to parse xhr response text (" + error.message + ")", "error");
            }

            return response;
        },

        sendChunksCompleteRequest = function(id) {
            var promise = new qq.Promise();

            allChunksDoneRequester.complete(
                    id,
                    handler._createXhr(id),
                    getChunksCompleteParams(id),
                    spec.customHeaders.get(id)
                )
                .then(function(xhr) {
                    promise.success(parseResponse(false, xhr), xhr);
                }, function(xhr) {
                    promise.failure(parseResponse(false, xhr), xhr);
                });

            return promise;
        },

        setParamsAndGetEntityToSend = function(params, xhr, fileOrBlob, id) {
            var formData = new FormData(),
                method = spec.method,
                endpoint = spec.endpointStore.get(id),
                name = getName(id),
                size = getSize(id);

            params[spec.uuidName] = getUuid(id);
            params[spec.filenameParam] = name;

            if (multipart) {
                params[spec.totalFileSizeName] = size;
            }

            //build query string
            if (!spec.paramsInBody) {
                if (!multipart) {
                    params[spec.inputName] = name;
                }
                endpoint = qq.obj2url(params, endpoint);
            }

            xhr.open(method, endpoint, true);

            if (spec.cors.expected && spec.cors.sendCredentials) {
                xhr.withCredentials = true;
            }

            if (multipart) {
                if (spec.paramsInBody) {
                    qq.obj2FormData(params, formData);
                }

                formData.append(spec.inputName, fileOrBlob);
                return formData;
            }

            return fileOrBlob;
        },

        setUploadHeaders = function(id, xhr) {
            var extraHeaders = spec.customHeaders.get(id),
                fileOrBlob = handler.getFile(id);

            xhr.setRequestHeader("Accept", "application/json");
            xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            xhr.setRequestHeader("Cache-Control", "no-cache");

            if (!multipart) {
                xhr.setRequestHeader("Content-Type", "application/octet-stream");
                //NOTE: return mime type in xhr works on chrome 16.0.9 firefox 11.0a2
                xhr.setRequestHeader("X-Mime-Type", fileOrBlob.type);
            }

            qq.each(extraHeaders, function(name, val) {
                xhr.setRequestHeader(name, val);
            });
        };

    qq.extend(this, {
        uploadChunk: function(id, chunkIdx, resuming) {
            var chunkData = handler._getChunkData(id, chunkIdx),
                xhr = handler._createXhr(id, chunkIdx),
                size = getSize(id),
                promise, toSend, params;

            promise = createReadyStateChangedHandler(id, xhr);
            handler._registerProgressHandler(id, chunkIdx, chunkData.size);
            params = spec.paramsStore.get(id);
            addChunkingSpecificParams(id, params, chunkData);

            if (resuming) {
                params[spec.resume.paramNames.resuming] = true;
            }

            toSend = setParamsAndGetEntityToSend(params, xhr, chunkData.blob, id);
            setUploadHeaders(id, xhr);
            xhr.send(toSend);

            return promise;
        },

        uploadFile: function(id) {
            var fileOrBlob = handler.getFile(id),
                promise, xhr, params, toSend;

            xhr = handler._createXhr(id);
            handler._registerProgressHandler(id);
            promise = createReadyStateChangedHandler(id, xhr);
            params = spec.paramsStore.get(id);
            toSend = setParamsAndGetEntityToSend(params, xhr, fileOrBlob, id);
            setUploadHeaders(id, xhr);
            xhr.send(toSend);

            return promise;
        }
    });

    qq.extend(this, new qq.XhrUploadHandler({
        options: qq.extend({namespace: "traditional"}, spec),
        proxy: qq.extend({getEndpoint: spec.endpointStore.get}, proxy)
    }));

    qq.override(this, function(super_) {
        return {
            finalizeChunks: function(id) {
                if (spec.chunking.success.endpoint) {
                    return sendChunksCompleteRequest(id);
                }
                else {
                    return super_.finalizeChunks(id, qq.bind(parseResponse, this, true));
                }
            }
        };
    });
};

/*globals qq*/
/**
 * Ajax requester used to send a POST to a traditional endpoint once all chunks for a specific file have uploaded
 * successfully.
 *
 * @param o Options from the caller - will override the defaults.
 * @constructor
 */
qq.traditional.AllChunksDoneAjaxRequester = function(o) {
    "use strict";

    var requester,
        method = "POST",
        options = {
            cors: {
                allowXdr: false,
                expected: false,
                sendCredentials: false
            },
            endpoint: null,
            log: function(str, level) {}
        },
        promises = {},
        endpointHandler = {
            get: function(id) {
                return options.endpoint;
            }
        };

    qq.extend(options, o);

    requester = qq.extend(this, new qq.AjaxRequester({
        acceptHeader: "application/json",
        validMethods: [method],
        method: method,
        endpointStore: endpointHandler,
        allowXRequestedWithAndCacheControl: false,
        cors: options.cors,
        log: options.log,
        onComplete: function(id, xhr, isError) {
            var promise = promises[id];

            delete promises[id];

            if (isError) {
                promise.failure(xhr);
            }
            else {
                promise.success(xhr);
            }
        }
    }));

    qq.extend(this, {
        complete: function(id, xhr, params, headers) {
            var promise = new qq.Promise();

            options.log("Submitting All Chunks Done request for " + id);

            promises[id] = promise;

            requester.initTransport(id)
                .withParams(params)
                .withHeaders(headers)
                .send(xhr);

            return promise;
        }
    });
};

/*globals qq*/
qq.PasteSupport = function(o) {
    "use strict";

    var options, detachPasteHandler;

    options = {
        targetElement: null,
        callbacks: {
            log: function(message, level) {},
            pasteReceived: function(blob) {}
        }
    };

    function isImage(item) {
        return item.type &&
            item.type.indexOf("image/") === 0;
    }

    function registerPasteHandler() {
        detachPasteHandler = qq(options.targetElement).attach("paste", function(event) {
            var clipboardData = event.clipboardData;

            if (clipboardData) {
                qq.each(clipboardData.items, function(idx, item) {
                    if (isImage(item)) {
                        var blob = item.getAsFile();
                        options.callbacks.pasteReceived(blob);
                    }
                });
            }
        });
    }

    function unregisterPasteHandler() {
        if (detachPasteHandler) {
            detachPasteHandler();
        }
    }

    qq.extend(options, o);
    registerPasteHandler();

    qq.extend(this, {
        reset: function() {
            unregisterPasteHandler();
        }
    });
};

/*globals qq, document, CustomEvent*/
qq.DragAndDrop = function(o) {
    "use strict";

    var options,
        HIDE_ZONES_EVENT_NAME = "qq-hidezones",
        HIDE_BEFORE_ENTER_ATTR = "qq-hide-dropzone",
        uploadDropZones = [],
        droppedFiles = [],
        disposeSupport = new qq.DisposeSupport();

    options = {
        dropZoneElements: [],
        allowMultipleItems: true,
        classes: {
            dropActive: null
        },
        callbacks: new qq.DragAndDrop.callbacks()
    };

    qq.extend(options, o, true);

    function uploadDroppedFiles(files, uploadDropZone) {
        // We need to convert the `FileList` to an actual `Array` to avoid iteration issues
        var filesAsArray = Array.prototype.slice.call(files);

        options.callbacks.dropLog("Grabbed " + files.length + " dropped files.");
        uploadDropZone.dropDisabled(false);
        options.callbacks.processingDroppedFilesComplete(filesAsArray, uploadDropZone.getElement());
    }

    function traverseFileTree(entry) {
        var parseEntryPromise = new qq.Promise();

        if (entry.isFile) {
            entry.file(function(file) {
                var name = entry.name,
                    fullPath = entry.fullPath,
                    indexOfNameInFullPath = fullPath.indexOf(name);

                // remove file name from full path string
                fullPath = fullPath.substr(0, indexOfNameInFullPath);

                // remove leading slash in full path string
                if (fullPath.charAt(0) === "/") {
                    fullPath = fullPath.substr(1);
                }

                file.qqPath = fullPath;
                droppedFiles.push(file);
                parseEntryPromise.success();
            },
            function(fileError) {
                options.callbacks.dropLog("Problem parsing '" + entry.fullPath + "'.  FileError code " + fileError.code + ".", "error");
                parseEntryPromise.failure();
            });
        }
        else if (entry.isDirectory) {
            getFilesInDirectory(entry).then(
                function allEntriesRead(entries) {
                    var entriesLeft = entries.length;

                    qq.each(entries, function(idx, entry) {
                        traverseFileTree(entry).done(function() {
                            entriesLeft -= 1;

                            if (entriesLeft === 0) {
                                parseEntryPromise.success();
                            }
                        });
                    });

                    if (!entries.length) {
                        parseEntryPromise.success();
                    }
                },

                function readFailure(fileError) {
                    options.callbacks.dropLog("Problem parsing '" + entry.fullPath + "'.  FileError code " + fileError.code + ".", "error");
                    parseEntryPromise.failure();
                }
            );
        }

        return parseEntryPromise;
    }

    // Promissory.  Guaranteed to read all files in the root of the passed directory.
    function getFilesInDirectory(entry, reader, accumEntries, existingPromise) {
        var promise = existingPromise || new qq.Promise(),
            dirReader = reader || entry.createReader();

        dirReader.readEntries(
            function readSuccess(entries) {
                var newEntries = accumEntries ? accumEntries.concat(entries) : entries;

                if (entries.length) {
                    setTimeout(function() { // prevent stack overflow, however unlikely
                        getFilesInDirectory(entry, dirReader, newEntries, promise);
                    }, 0);
                }
                else {
                    promise.success(newEntries);
                }
            },

            promise.failure
        );

        return promise;
    }

    function handleDataTransfer(dataTransfer, uploadDropZone) {
        var pendingFolderPromises = [],
            handleDataTransferPromise = new qq.Promise();

        options.callbacks.processingDroppedFiles();
        uploadDropZone.dropDisabled(true);

        if (dataTransfer.files.length > 1 && !options.allowMultipleItems) {
            options.callbacks.processingDroppedFilesComplete([]);
            options.callbacks.dropError("tooManyFilesError", "");
            uploadDropZone.dropDisabled(false);
            handleDataTransferPromise.failure();
        }
        else {
            droppedFiles = [];

            if (qq.isFolderDropSupported(dataTransfer)) {
                qq.each(dataTransfer.items, function(idx, item) {
                    var entry = item.webkitGetAsEntry();

                    if (entry) {
                        //due to a bug in Chrome's File System API impl - #149735
                        if (entry.isFile) {
                            droppedFiles.push(item.getAsFile());
                        }

                        else {
                            pendingFolderPromises.push(traverseFileTree(entry).done(function() {
                                pendingFolderPromises.pop();
                                if (pendingFolderPromises.length === 0) {
                                    handleDataTransferPromise.success();
                                }
                            }));
                        }
                    }
                });
            }
            else {
                droppedFiles = dataTransfer.files;
            }

            if (pendingFolderPromises.length === 0) {
                handleDataTransferPromise.success();
            }
        }

        return handleDataTransferPromise;
    }

    function setupDropzone(dropArea) {
        var dropZone = new qq.UploadDropZone({
            HIDE_ZONES_EVENT_NAME: HIDE_ZONES_EVENT_NAME,
            element: dropArea,
            onEnter: function(e) {
                qq(dropArea).addClass(options.classes.dropActive);
                e.stopPropagation();
            },
            onLeaveNotDescendants: function(e) {
                qq(dropArea).removeClass(options.classes.dropActive);
            },
            onDrop: function(e) {
                handleDataTransfer(e.dataTransfer, dropZone).then(
                    function() {
                        uploadDroppedFiles(droppedFiles, dropZone);
                    },
                    function() {
                        options.callbacks.dropLog("Drop event DataTransfer parsing failed.  No files will be uploaded.", "error");
                    }
                );
            }
        });

        disposeSupport.addDisposer(function() {
            dropZone.dispose();
        });

        qq(dropArea).hasAttribute(HIDE_BEFORE_ENTER_ATTR) && qq(dropArea).hide();

        uploadDropZones.push(dropZone);

        return dropZone;
    }

    function isFileDrag(dragEvent) {
        var fileDrag;

        qq.each(dragEvent.dataTransfer.types, function(key, val) {
            if (val === "Files") {
                fileDrag = true;
                return false;
            }
        });

        return fileDrag;
    }

    // Attempt to determine when the file has left the document.  It is not always possible to detect this
    // in all cases, but it is generally possible in all browsers, with a few exceptions.
    //
    // Exceptions:
    // * IE10+ & Safari: We can't detect a file leaving the document if the Explorer window housing the file
    //                   overlays the browser window.
    // * IE10+: If the file is dragged out of the window too quickly, IE does not set the expected values of the
    //          event's X & Y properties.
    function leavingDocumentOut(e) {
        if (qq.firefox()) {
            return !e.relatedTarget;
        }

        if (qq.safari()) {
            return e.x < 0 || e.y < 0;
        }

        return e.x === 0 && e.y === 0;
    }

    function setupDragDrop() {
        var dropZones = options.dropZoneElements,

            maybeHideDropZones = function() {
                setTimeout(function() {
                    qq.each(dropZones, function(idx, dropZone) {
                        qq(dropZone).hasAttribute(HIDE_BEFORE_ENTER_ATTR) && qq(dropZone).hide();
                        qq(dropZone).removeClass(options.classes.dropActive);
                    });
                }, 10);
            };

        qq.each(dropZones, function(idx, dropZone) {
            var uploadDropZone = setupDropzone(dropZone);

            // IE <= 9 does not support the File API used for drag+drop uploads
            if (dropZones.length && qq.supportedFeatures.fileDrop) {
                disposeSupport.attach(document, "dragenter", function(e) {
                    if (!uploadDropZone.dropDisabled() && isFileDrag(e)) {
                        qq.each(dropZones, function(idx, dropZone) {
                            // We can't apply styles to non-HTMLElements, since they lack the `style` property.
                            // Also, if the drop zone isn't initially hidden, let's not mess with `style.display`.
                            if (dropZone instanceof HTMLElement &&
                                qq(dropZone).hasAttribute(HIDE_BEFORE_ENTER_ATTR)) {

                                qq(dropZone).css({display: "block"});
                            }
                        });
                    }
                });
            }
        });

        disposeSupport.attach(document, "dragleave", function(e) {
            if (leavingDocumentOut(e)) {
                maybeHideDropZones();
            }
        });

        // Just in case we were not able to detect when a dragged file has left the document,
        // hide all relevant drop zones the next time the mouse enters the document.
        // Note that mouse events such as this one are not fired during drag operations.
        disposeSupport.attach(qq(document).children()[0], "mouseenter", function(e) {
            maybeHideDropZones();
        });

        disposeSupport.attach(document, "drop", function(e) {
            e.preventDefault();
            maybeHideDropZones();
        });

        disposeSupport.attach(document, HIDE_ZONES_EVENT_NAME, maybeHideDropZones);
    }

    setupDragDrop();

    qq.extend(this, {
        setupExtraDropzone: function(element) {
            options.dropZoneElements.push(element);
            setupDropzone(element);
        },

        removeDropzone: function(element) {
            var i,
                dzs = options.dropZoneElements;

            for (i in dzs) {
                if (dzs[i] === element) {
                    return dzs.splice(i, 1);
                }
            }
        },

        dispose: function() {
            disposeSupport.dispose();
            qq.each(uploadDropZones, function(idx, dropZone) {
                dropZone.dispose();
            });
        }
    });
};

qq.DragAndDrop.callbacks = function() {
    "use strict";

    return {
        processingDroppedFiles: function() {},
        processingDroppedFilesComplete: function(files, targetEl) {},
        dropError: function(code, errorSpecifics) {
            qq.log("Drag & drop error code '" + code + " with these specifics: '" + errorSpecifics + "'", "error");
        },
        dropLog: function(message, level) {
            qq.log(message, level);
        }
    };
};

qq.UploadDropZone = function(o) {
    "use strict";

    var disposeSupport = new qq.DisposeSupport(),
        options, element, preventDrop, dropOutsideDisabled;

    options = {
        element: null,
        onEnter: function(e) {},
        onLeave: function(e) {},
        // is not fired when leaving element by hovering descendants
        onLeaveNotDescendants: function(e) {},
        onDrop: function(e) {}
    };

    qq.extend(options, o);
    element = options.element;

    function dragoverShouldBeCanceled() {
        return qq.safari() || (qq.firefox() && qq.windows());
    }

    function disableDropOutside(e) {
        // run only once for all instances
        if (!dropOutsideDisabled) {

            // for these cases we need to catch onDrop to reset dropArea
            if (dragoverShouldBeCanceled) {
                disposeSupport.attach(document, "dragover", function(e) {
                    e.preventDefault();
                });
            } else {
                disposeSupport.attach(document, "dragover", function(e) {
                    if (e.dataTransfer) {
                        e.dataTransfer.dropEffect = "none";
                        e.preventDefault();
                    }
                });
            }

            dropOutsideDisabled = true;
        }
    }

    function isValidFileDrag(e) {
        // e.dataTransfer currently causing IE errors
        // IE9 does NOT support file API, so drag-and-drop is not possible
        if (!qq.supportedFeatures.fileDrop) {
            return false;
        }

        var effectTest, dt = e.dataTransfer,
        // do not check dt.types.contains in webkit, because it crashes safari 4
        isSafari = qq.safari();

        // dt.effectAllowed is none in Safari 5
        // dt.types.contains check is for firefox

        // dt.effectAllowed crashes IE 11 & 10 when files have been dragged from
        // the filesystem
        effectTest = qq.ie() && qq.supportedFeatures.fileDrop ? true : dt.effectAllowed !== "none";
        return dt && effectTest && (dt.files || (!isSafari && dt.types.contains && dt.types.contains("Files")));
    }

    function isOrSetDropDisabled(isDisabled) {
        if (isDisabled !== undefined) {
            preventDrop = isDisabled;
        }
        return preventDrop;
    }

    function triggerHidezonesEvent() {
        var hideZonesEvent;

        function triggerUsingOldApi() {
            hideZonesEvent = document.createEvent("Event");
            hideZonesEvent.initEvent(options.HIDE_ZONES_EVENT_NAME, true, true);
        }

        if (window.CustomEvent) {
            try {
                hideZonesEvent = new CustomEvent(options.HIDE_ZONES_EVENT_NAME);
            }
            catch (err) {
                triggerUsingOldApi();
            }
        }
        else {
            triggerUsingOldApi();
        }

        document.dispatchEvent(hideZonesEvent);
    }

    function attachEvents() {
        disposeSupport.attach(element, "dragover", function(e) {
            if (!isValidFileDrag(e)) {
                return;
            }

            // dt.effectAllowed crashes IE 11 & 10 when files have been dragged from
            // the filesystem
            var effect = qq.ie() && qq.supportedFeatures.fileDrop ? null : e.dataTransfer.effectAllowed;
            if (effect === "move" || effect === "linkMove") {
                e.dataTransfer.dropEffect = "move"; // for FF (only move allowed)
            } else {
                e.dataTransfer.dropEffect = "copy"; // for Chrome
            }

            e.stopPropagation();
            e.preventDefault();
        });

        disposeSupport.attach(element, "dragenter", function(e) {
            if (!isOrSetDropDisabled()) {
                if (!isValidFileDrag(e)) {
                    return;
                }
                options.onEnter(e);
            }
        });

        disposeSupport.attach(element, "dragleave", function(e) {
            if (!isValidFileDrag(e)) {
                return;
            }

            options.onLeave(e);

            var relatedTarget = document.elementFromPoint(e.clientX, e.clientY);
            // do not fire when moving a mouse over a descendant
            if (qq(this).contains(relatedTarget)) {
                return;
            }

            options.onLeaveNotDescendants(e);
        });

        disposeSupport.attach(element, "drop", function(e) {
            if (!isOrSetDropDisabled()) {
                if (!isValidFileDrag(e)) {
                    return;
                }

                e.preventDefault();
                e.stopPropagation();
                options.onDrop(e);

                triggerHidezonesEvent();
            }
        });
    }

    disableDropOutside();
    attachEvents();

    qq.extend(this, {
        dropDisabled: function(isDisabled) {
            return isOrSetDropDisabled(isDisabled);
        },

        dispose: function() {
            disposeSupport.dispose();
        },

        getElement: function() {
            return element;
        }
    });
};

/*globals qq, XMLHttpRequest*/
qq.DeleteFileAjaxRequester = function(o) {
    "use strict";

    var requester,
        options = {
            method: "DELETE",
            uuidParamName: "qquuid",
            endpointStore: {},
            maxConnections: 3,
            customHeaders: function(id) {return {};},
            paramsStore: {},
            cors: {
                expected: false,
                sendCredentials: false
            },
            log: function(str, level) {},
            onDelete: function(id) {},
            onDeleteComplete: function(id, xhrOrXdr, isError) {}
        };

    qq.extend(options, o);

    function getMandatedParams() {
        if (options.method.toUpperCase() === "POST") {
            return {
                _method: "DELETE"
            };
        }

        return {};
    }

    requester = qq.extend(this, new qq.AjaxRequester({
        acceptHeader: "application/json",
        validMethods: ["POST", "DELETE"],
        method: options.method,
        endpointStore: options.endpointStore,
        paramsStore: options.paramsStore,
        mandatedParams: getMandatedParams(),
        maxConnections: options.maxConnections,
        customHeaders: function(id) {
            return options.customHeaders.get(id);
        },
        log: options.log,
        onSend: options.onDelete,
        onComplete: options.onDeleteComplete,
        cors: options.cors
    }));

    qq.extend(this, {
        sendDelete: function(id, uuid, additionalMandatedParams) {
            var additionalOptions = additionalMandatedParams || {};

            options.log("Submitting delete file request for " + id);

            if (options.method === "DELETE") {
                requester.initTransport(id)
                    .withPath(uuid)
                    .withParams(additionalOptions)
                    .send();
            }
            else {
                additionalOptions[options.uuidParamName] = uuid;
                requester.initTransport(id)
                    .withParams(additionalOptions)
                    .send();
            }
        }
    });
};

/*global qq, define */
/*jshint strict:false,bitwise:false,nonew:false,asi:true,-W064,-W116,-W089 */
/**
 * Mega pixel image rendering library for iOS6+
 *
 * Fixes iOS6+'s image file rendering issue for large size image (over mega-pixel),
 * which causes unexpected subsampling when drawing it in canvas.
 * By using this library, you can safely render the image with proper stretching.
 *
 * Copyright (c) 2012 Shinichi Tomita <shinichi.tomita@gmail.com>
 * Released under the MIT license
 *
 * Heavily modified by Widen for Fine Uploader
 */
(function() {

    /**
     * Detect subsampling in loaded image.
     * In iOS, larger images than 2M pixels may be subsampled in rendering.
     */
    function detectSubsampling(img) {
        var iw = img.naturalWidth,
            ih = img.naturalHeight,
            canvas = document.createElement("canvas"),
            ctx;

        if (iw * ih > 1024 * 1024) { // subsampling may happen over megapixel image
            canvas.width = canvas.height = 1;
            ctx = canvas.getContext("2d");
            ctx.drawImage(img, -iw + 1, 0);
            // subsampled image becomes half smaller in rendering size.
            // check alpha channel value to confirm image is covering edge pixel or not.
            // if alpha value is 0 image is not covering, hence subsampled.
            return ctx.getImageData(0, 0, 1, 1).data[3] === 0;
        } else {
            return false;
        }
    }

    /**
     * Detecting vertical squash in loaded image.
     * Fixes a bug which squash image vertically while drawing into canvas for some images.
     */
    function detectVerticalSquash(img, iw, ih) {
        var canvas = document.createElement("canvas"),
            sy = 0,
            ey = ih,
            py = ih,
            ctx, data, alpha, ratio;

        canvas.width = 1;
        canvas.height = ih;
        ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);
        data = ctx.getImageData(0, 0, 1, ih).data;

        // search image edge pixel position in case it is squashed vertically.
        while (py > sy) {
            alpha = data[(py - 1) * 4 + 3];
            if (alpha === 0) {
                ey = py;
            } else {
                sy = py;
            }
            py = (ey + sy) >> 1;
        }

        ratio = (py / ih);
        return (ratio === 0) ? 1 : ratio;
    }

    /**
     * Rendering image element (with resizing) and get its data URL
     */
    function renderImageToDataURL(img, blob, options, doSquash) {
        var canvas = document.createElement("canvas"),
            mime = options.mime || "image/jpeg",
            promise = new qq.Promise();

        renderImageToCanvas(img, blob, canvas, options, doSquash)
            .then(function() {
                promise.success(
                    canvas.toDataURL(mime, options.quality || 0.8)
                );
            })

        return promise;
    }

    function maybeCalculateDownsampledDimensions(spec) {
        var maxPixels = 5241000; //iOS specific value

        if (!qq.ios()) {
            throw new qq.Error("Downsampled dimensions can only be reliably calculated for iOS!");
        }

        if (spec.origHeight * spec.origWidth > maxPixels) {
            return {
                newHeight: Math.round(Math.sqrt(maxPixels * (spec.origHeight / spec.origWidth))),
                newWidth: Math.round(Math.sqrt(maxPixels * (spec.origWidth / spec.origHeight)))
            }
        }
    }

    /**
     * Rendering image element (with resizing) into the canvas element
     */
    function renderImageToCanvas(img, blob, canvas, options, doSquash) {
        var iw = img.naturalWidth,
            ih = img.naturalHeight,
            width = options.width,
            height = options.height,
            ctx = canvas.getContext("2d"),
            promise = new qq.Promise(),
            modifiedDimensions;

        ctx.save();

        if (options.resize) {
            return renderImageToCanvasWithCustomResizer({
                blob: blob,
                canvas: canvas,
                image: img,
                imageHeight: ih,
                imageWidth: iw,
                orientation: options.orientation,
                resize: options.resize,
                targetHeight: height,
                targetWidth: width
            })
        }

        if (!qq.supportedFeatures.unlimitedScaledImageSize) {
            modifiedDimensions = maybeCalculateDownsampledDimensions({
                origWidth: width,
                origHeight: height
            });

            if (modifiedDimensions) {
                qq.log(qq.format("Had to reduce dimensions due to device limitations from {}w / {}h to {}w / {}h",
                    width, height, modifiedDimensions.newWidth, modifiedDimensions.newHeight),
                    "warn");

                width = modifiedDimensions.newWidth;
                height = modifiedDimensions.newHeight;
            }
        }

        transformCoordinate(canvas, width, height, options.orientation);

        // Fine Uploader specific: Save some CPU cycles if not using iOS
        // Assumption: This logic is only needed to overcome iOS image sampling issues
        if (qq.ios()) {
            (function() {
                if (detectSubsampling(img)) {
                    iw /= 2;
                    ih /= 2;
                }

                var d = 1024, // size of tiling canvas
                    tmpCanvas = document.createElement("canvas"),
                    vertSquashRatio = doSquash ? detectVerticalSquash(img, iw, ih) : 1,
                    dw = Math.ceil(d * width / iw),
                    dh = Math.ceil(d * height / ih / vertSquashRatio),
                    sy = 0,
                    dy = 0,
                    tmpCtx, sx, dx;

                tmpCanvas.width = tmpCanvas.height = d;
                tmpCtx = tmpCanvas.getContext("2d");

                while (sy < ih) {
                    sx = 0;
                    dx = 0;
                    while (sx < iw) {
                        tmpCtx.clearRect(0, 0, d, d);
                        tmpCtx.drawImage(img, -sx, -sy);
                        ctx.drawImage(tmpCanvas, 0, 0, d, d, dx, dy, dw, dh);
                        sx += d;
                        dx += dw;
                    }
                    sy += d;
                    dy += dh;
                }
                ctx.restore();
                tmpCanvas = tmpCtx = null;
            }())
        }
        else {
            ctx.drawImage(img, 0, 0, width, height);
        }

        canvas.qqImageRendered && canvas.qqImageRendered();
        promise.success();

        return promise;
    }

    function renderImageToCanvasWithCustomResizer(resizeInfo) {
        var blob = resizeInfo.blob,
            image = resizeInfo.image,
            imageHeight = resizeInfo.imageHeight,
            imageWidth = resizeInfo.imageWidth,
            orientation = resizeInfo.orientation,
            promise = new qq.Promise(),
            resize = resizeInfo.resize,
            sourceCanvas = document.createElement("canvas"),
            sourceCanvasContext = sourceCanvas.getContext("2d"),
            targetCanvas = resizeInfo.canvas,
            targetHeight = resizeInfo.targetHeight,
            targetWidth = resizeInfo.targetWidth;

        transformCoordinate(sourceCanvas, imageWidth, imageHeight, orientation);

        targetCanvas.height = targetHeight;
        targetCanvas.width = targetWidth;

        sourceCanvasContext.drawImage(image, 0, 0);

        resize({
            blob: blob,
            height: targetHeight,
            image: image,
            sourceCanvas: sourceCanvas,
            targetCanvas: targetCanvas,
            width: targetWidth
        })
            .then(
                function success() {
                    targetCanvas.qqImageRendered && targetCanvas.qqImageRendered();
                    promise.success();
                },
                promise.failure
            )

        return promise;
    }

    /**
     * Transform canvas coordination according to specified frame size and orientation
     * Orientation value is from EXIF tag
     */
    function transformCoordinate(canvas, width, height, orientation) {
        switch (orientation) {
            case 5:
            case 6:
            case 7:
            case 8:
                canvas.width = height;
                canvas.height = width;
                break;
            default:
                canvas.width = width;
                canvas.height = height;
        }
        var ctx = canvas.getContext("2d");
        switch (orientation) {
            case 2:
                // horizontal flip
                ctx.translate(width, 0);
                ctx.scale(-1, 1);
                break;
            case 3:
                // 180 rotate left
                ctx.translate(width, height);
                ctx.rotate(Math.PI);
                break;
            case 4:
                // vertical flip
                ctx.translate(0, height);
                ctx.scale(1, -1);
                break;
            case 5:
                // vertical flip + 90 rotate right
                ctx.rotate(0.5 * Math.PI);
                ctx.scale(1, -1);
                break;
            case 6:
                // 90 rotate right
                ctx.rotate(0.5 * Math.PI);
                ctx.translate(0, -height);
                break;
            case 7:
                // horizontal flip + 90 rotate right
                ctx.rotate(0.5 * Math.PI);
                ctx.translate(width, -height);
                ctx.scale(-1, 1);
                break;
            case 8:
                // 90 rotate left
                ctx.rotate(-0.5 * Math.PI);
                ctx.translate(-width, 0);
                break;
            default:
                break;
        }
    }

    /**
     * MegaPixImage class
     */
    function MegaPixImage(srcImage, errorCallback) {
        var self = this;

        if (window.Blob && srcImage instanceof Blob) {
            (function() {
                var img = new Image(),
                    URL = window.URL && window.URL.createObjectURL ? window.URL :
                        window.webkitURL && window.webkitURL.createObjectURL ? window.webkitURL : null;
                if (!URL) { throw Error("No createObjectURL function found to create blob url"); }
                img.src = URL.createObjectURL(srcImage);
                self.blob = srcImage;
                srcImage = img;
            }());
        }
        if (!srcImage.naturalWidth && !srcImage.naturalHeight) {
            srcImage.onload = function() {
                var listeners = self.imageLoadListeners;
                if (listeners) {
                    self.imageLoadListeners = null;
                    // IE11 doesn't reliably report actual image dimensions immediately after onload for small files,
                    // so let's push this to the end of the UI thread queue.
                    setTimeout(function() {
                        for (var i = 0, len = listeners.length; i < len; i++) {
                            listeners[i]();
                        }
                    }, 0);
                }
            };
            srcImage.onerror = errorCallback;
            this.imageLoadListeners = [];
        }
        this.srcImage = srcImage;
    }

    /**
     * Rendering megapix image into specified target element
     */
    MegaPixImage.prototype.render = function(target, options) {
        options = options || {};

        var self = this,
            imgWidth = this.srcImage.naturalWidth,
            imgHeight = this.srcImage.naturalHeight,
            width = options.width,
            height = options.height,
            maxWidth = options.maxWidth,
            maxHeight = options.maxHeight,
            doSquash = !this.blob || this.blob.type === "image/jpeg",
            tagName = target.tagName.toLowerCase(),
            opt;

        if (this.imageLoadListeners) {
            this.imageLoadListeners.push(function() { self.render(target, options) });
            return;
        }

        if (width && !height) {
            height = (imgHeight * width / imgWidth) << 0;
        } else if (height && !width) {
            width = (imgWidth * height / imgHeight) << 0;
        } else {
            width = imgWidth;
            height = imgHeight;
        }
        if (maxWidth && width > maxWidth) {
            width = maxWidth;
            height = (imgHeight * width / imgWidth) << 0;
        }
        if (maxHeight && height > maxHeight) {
            height = maxHeight;
            width = (imgWidth * height / imgHeight) << 0;
        }

        opt = { width: width, height: height },
        qq.each(options, function(optionsKey, optionsValue) {
            opt[optionsKey] = optionsValue;
        });

        if (tagName === "img") {
            (function() {
                var oldTargetSrc = target.src;
                renderImageToDataURL(self.srcImage, self.blob, opt, doSquash)
                    .then(function(dataUri) {
                        target.src = dataUri;
                        oldTargetSrc === target.src && target.onload();
                    });
            }())
        } else if (tagName === "canvas") {
            renderImageToCanvas(this.srcImage, this.blob, target, opt, doSquash);
        }
        if (typeof this.onrender === "function") {
            this.onrender(target);
        }
    };

    qq.MegaPixImage = MegaPixImage;
})();

/*globals qq */
/**
 * Draws a thumbnail of a Blob/File/URL onto an <img> or <canvas>.
 *
 * @constructor
 */
qq.ImageGenerator = function(log) {
    "use strict";

    function isImg(el) {
        return el.tagName.toLowerCase() === "img";
    }

    function isCanvas(el) {
        return el.tagName.toLowerCase() === "canvas";
    }

    function isImgCorsSupported() {
        return new Image().crossOrigin !== undefined;
    }

    function isCanvasSupported() {
        var canvas = document.createElement("canvas");

        return canvas.getContext && canvas.getContext("2d");
    }

    // This is only meant to determine the MIME type of a renderable image file.
    // It is used to ensure images drawn from a URL that have transparent backgrounds
    // are rendered correctly, among other things.
    function determineMimeOfFileName(nameWithPath) {
        /*jshint -W015 */
        var pathSegments = nameWithPath.split("/"),
            name = pathSegments[pathSegments.length - 1],
            extension = qq.getExtension(name);

        extension = extension && extension.toLowerCase();

        switch (extension) {
            case "jpeg":
            case "jpg":
                return "image/jpeg";
            case "png":
                return "image/png";
            case "bmp":
                return "image/bmp";
            case "gif":
                return "image/gif";
            case "tiff":
            case "tif":
                return "image/tiff";
        }
    }

    // This will likely not work correctly in IE8 and older.
    // It's only used as part of a formula to determine
    // if a canvas can be used to scale a server-hosted thumbnail.
    // If canvas isn't supported by the UA (IE8 and older)
    // this method should not even be called.
    function isCrossOrigin(url) {
        var targetAnchor = document.createElement("a"),
            targetProtocol, targetHostname, targetPort;

        targetAnchor.href = url;

        targetProtocol = targetAnchor.protocol;
        targetPort = targetAnchor.port;
        targetHostname = targetAnchor.hostname;

        if (targetProtocol.toLowerCase() !== window.location.protocol.toLowerCase()) {
            return true;
        }

        if (targetHostname.toLowerCase() !== window.location.hostname.toLowerCase()) {
            return true;
        }

        // IE doesn't take ports into consideration when determining if two endpoints are same origin.
        if (targetPort !== window.location.port && !qq.ie()) {
            return true;
        }

        return false;
    }

    function registerImgLoadListeners(img, promise) {
        img.onload = function() {
            img.onload = null;
            img.onerror = null;
            promise.success(img);
        };

        img.onerror = function() {
            img.onload = null;
            img.onerror = null;
            log("Problem drawing thumbnail!", "error");
            promise.failure(img, "Problem drawing thumbnail!");
        };
    }

    function registerCanvasDrawImageListener(canvas, promise) {
        // The image is drawn on the canvas by a third-party library,
        // and we want to know when this is completed.  Since the library
        // may invoke drawImage many times in a loop, we need to be called
        // back when the image is fully rendered.  So, we are expecting the
        // code that draws this image to follow a convention that involves a
        // function attached to the canvas instance be invoked when it is done.
        canvas.qqImageRendered = function() {
            promise.success(canvas);
        };
    }

    // Fulfills a `qq.Promise` when an image has been drawn onto the target,
    // whether that is a <canvas> or an <img>.  The attempt is considered a
    // failure if the target is not an <img> or a <canvas>, or if the drawing
    // attempt was not successful.
    function registerThumbnailRenderedListener(imgOrCanvas, promise) {
        var registered = isImg(imgOrCanvas) || isCanvas(imgOrCanvas);

        if (isImg(imgOrCanvas)) {
            registerImgLoadListeners(imgOrCanvas, promise);
        }
        else if (isCanvas(imgOrCanvas)) {
            registerCanvasDrawImageListener(imgOrCanvas, promise);
        }
        else {
            promise.failure(imgOrCanvas);
            log(qq.format("Element container of type {} is not supported!", imgOrCanvas.tagName), "error");
        }

        return registered;
    }

    // Draw a preview iff the current UA can natively display it.
    // Also rotate the image if necessary.
    function draw(fileOrBlob, container, options) {
        var drawPreview = new qq.Promise(),
            identifier = new qq.Identify(fileOrBlob, log),
            maxSize = options.maxSize,
            // jshint eqnull:true
            orient = options.orient == null ? true : options.orient,
            megapixErrorHandler = function() {
                container.onerror = null;
                container.onload = null;
                log("Could not render preview, file may be too large!", "error");
                drawPreview.failure(container, "Browser cannot render image!");
            };

        identifier.isPreviewable().then(
            function(mime) {
                // If options explicitly specify that Orientation is not desired,
                // replace the orient task with a dummy promise that "succeeds" immediately.
                var dummyExif = {
                        parse: function() {
                            return new qq.Promise().success();
                        }
                    },
                    exif = orient ? new qq.Exif(fileOrBlob, log) : dummyExif,
                    mpImg = new qq.MegaPixImage(fileOrBlob, megapixErrorHandler);

                if (registerThumbnailRenderedListener(container, drawPreview)) {
                    exif.parse().then(
                        function(exif) {
                            var orientation = exif && exif.Orientation;

                            mpImg.render(container, {
                                maxWidth: maxSize,
                                maxHeight: maxSize,
                                orientation: orientation,
                                mime: mime,
                                resize: options.customResizeFunction
                            });
                        },

                        function(failureMsg) {
                            log(qq.format("EXIF data could not be parsed ({}).  Assuming orientation = 1.", failureMsg));

                            mpImg.render(container, {
                                maxWidth: maxSize,
                                maxHeight: maxSize,
                                mime: mime,
                                resize: options.customResizeFunction
                            });
                        }
                    );
                }
            },

            function() {
                log("Not previewable");
                drawPreview.failure(container, "Not previewable");
            }
        );

        return drawPreview;
    }

    function drawOnCanvasOrImgFromUrl(url, canvasOrImg, draw, maxSize, customResizeFunction) {
        var tempImg = new Image(),
            tempImgRender = new qq.Promise();

        registerThumbnailRenderedListener(tempImg, tempImgRender);

        if (isCrossOrigin(url)) {
            tempImg.crossOrigin = "anonymous";
        }

        tempImg.src = url;

        tempImgRender.then(
            function rendered() {
                registerThumbnailRenderedListener(canvasOrImg, draw);

                var mpImg = new qq.MegaPixImage(tempImg);
                mpImg.render(canvasOrImg, {
                    maxWidth: maxSize,
                    maxHeight: maxSize,
                    mime: determineMimeOfFileName(url),
                    resize: customResizeFunction
                });
            },

            draw.failure
        );
    }

    function drawOnImgFromUrlWithCssScaling(url, img, draw, maxSize) {
        registerThumbnailRenderedListener(img, draw);
        // NOTE: The fact that maxWidth/height is set on the thumbnail for scaled images
        // that must drop back to CSS is known and exploited by the templating module.
        // In this module, we pre-render "waiting" thumbs for all files immediately after they
        // are submitted, and we must be sure to pass any style associated with the "waiting" preview.
        qq(img).css({
            maxWidth: maxSize + "px",
            maxHeight: maxSize + "px"
        });

        img.src = url;
    }

    // Draw a (server-hosted) thumbnail given a URL.
    // This will optionally scale the thumbnail as well.
    // It attempts to use <canvas> to scale, but will fall back
    // to max-width and max-height style properties if the UA
    // doesn't support canvas or if the images is cross-domain and
    // the UA doesn't support the crossorigin attribute on img tags,
    // which is required to scale a cross-origin image using <canvas> &
    // then export it back to an <img>.
    function drawFromUrl(url, container, options) {
        var draw = new qq.Promise(),
            scale = options.scale,
            maxSize = scale ? options.maxSize : null;

        // container is an img, scaling needed
        if (scale && isImg(container)) {
            // Iff canvas is available in this UA, try to use it for scaling.
            // Otherwise, fall back to CSS scaling
            if (isCanvasSupported()) {
                // Attempt to use <canvas> for image scaling,
                // but we must fall back to scaling via CSS/styles
                // if this is a cross-origin image and the UA doesn't support <img> CORS.
                if (isCrossOrigin(url) && !isImgCorsSupported()) {
                    drawOnImgFromUrlWithCssScaling(url, container, draw, maxSize);
                }
                else {
                    drawOnCanvasOrImgFromUrl(url, container, draw, maxSize);
                }
            }
            else {
                drawOnImgFromUrlWithCssScaling(url, container, draw, maxSize);
            }
        }
        // container is a canvas, scaling optional
        else if (isCanvas(container)) {
            drawOnCanvasOrImgFromUrl(url, container, draw, maxSize);
        }
        // container is an img & no scaling: just set the src attr to the passed url
        else if (registerThumbnailRenderedListener(container, draw)) {
            container.src = url;
        }

        return draw;
    }

    qq.extend(this, {
        /**
         * Generate a thumbnail.  Depending on the arguments, this may either result in
         * a client-side rendering of an image (if a `Blob` is supplied) or a server-generated
         * image that may optionally be scaled client-side using <canvas> or CSS/styles (as a fallback).
         *
         * @param fileBlobOrUrl a `File`, `Blob`, or a URL pointing to the image
         * @param container <img> or <canvas> to contain the preview
         * @param options possible properties include `maxSize` (int), `orient` (bool - default true), resize` (bool - default true), and `customResizeFunction`.
         * @returns qq.Promise fulfilled when the preview has been drawn, or the attempt has failed
         */
        generate: function(fileBlobOrUrl, container, options) {
            if (qq.isString(fileBlobOrUrl)) {
                log("Attempting to update thumbnail based on server response.");
                return drawFromUrl(fileBlobOrUrl, container, options || {});
            }
            else {
                log("Attempting to draw client-side image preview.");
                return draw(fileBlobOrUrl, container, options || {});
            }
        }
    });

};

/*globals qq */
/**
 * EXIF image data parser.  Currently only parses the Orientation tag value,
 * but this may be expanded to other tags in the future.
 *
 * @param fileOrBlob Attempt to parse EXIF data in this `Blob`
 * @constructor
 */
qq.Exif = function(fileOrBlob, log) {
    "use strict";

    // Orientation is the only tag parsed here at this time.
    var TAG_IDS = [274],
        TAG_INFO = {
            274: {
                name: "Orientation",
                bytes: 2
            }
        };

    // Convert a little endian (hex string) to big endian (decimal).
    function parseLittleEndian(hex) {
        var result = 0,
            pow = 0;

        while (hex.length > 0) {
            result += parseInt(hex.substring(0, 2), 16) * Math.pow(2, pow);
            hex = hex.substring(2, hex.length);
            pow += 8;
        }

        return result;
    }

    // Find the byte offset, of Application Segment 1 (EXIF).
    // External callers need not supply any arguments.
    function seekToApp1(offset, promise) {
        var theOffset = offset,
            thePromise = promise;
        if (theOffset === undefined) {
            theOffset = 2;
            thePromise = new qq.Promise();
        }

        qq.readBlobToHex(fileOrBlob, theOffset, 4).then(function(hex) {
            var match = /^ffe([0-9])/.exec(hex),
                segmentLength;

            if (match) {
                if (match[1] !== "1") {
                    segmentLength = parseInt(hex.slice(4, 8), 16);
                    seekToApp1(theOffset + segmentLength + 2, thePromise);
                }
                else {
                    thePromise.success(theOffset);
                }
            }
            else {
                thePromise.failure("No EXIF header to be found!");
            }
        });

        return thePromise;
    }

    // Find the byte offset of Application Segment 1 (EXIF) for valid JPEGs only.
    function getApp1Offset() {
        var promise = new qq.Promise();

        qq.readBlobToHex(fileOrBlob, 0, 6).then(function(hex) {
            if (hex.indexOf("ffd8") !== 0) {
                promise.failure("Not a valid JPEG!");
            }
            else {
                seekToApp1().then(function(offset) {
                    promise.success(offset);
                },
                function(error) {
                    promise.failure(error);
                });
            }
        });

        return promise;
    }

    // Determine the byte ordering of the EXIF header.
    function isLittleEndian(app1Start) {
        var promise = new qq.Promise();

        qq.readBlobToHex(fileOrBlob, app1Start + 10, 2).then(function(hex) {
            promise.success(hex === "4949");
        });

        return promise;
    }

    // Determine the number of directory entries in the EXIF header.
    function getDirEntryCount(app1Start, littleEndian) {
        var promise = new qq.Promise();

        qq.readBlobToHex(fileOrBlob, app1Start + 18, 2).then(function(hex) {
            if (littleEndian) {
                return promise.success(parseLittleEndian(hex));
            }
            else {
                promise.success(parseInt(hex, 16));
            }
        });

        return promise;
    }

    // Get the IFD portion of the EXIF header as a hex string.
    function getIfd(app1Start, dirEntries) {
        var offset = app1Start + 20,
            bytes = dirEntries * 12;

        return qq.readBlobToHex(fileOrBlob, offset, bytes);
    }

    // Obtain an array of all directory entries (as hex strings) in the EXIF header.
    function getDirEntries(ifdHex) {
        var entries = [],
            offset = 0;

        while (offset + 24 <= ifdHex.length) {
            entries.push(ifdHex.slice(offset, offset + 24));
            offset += 24;
        }

        return entries;
    }

    // Obtain values for all relevant tags and return them.
    function getTagValues(littleEndian, dirEntries) {
        var TAG_VAL_OFFSET = 16,
            tagsToFind = qq.extend([], TAG_IDS),
            vals = {};

        qq.each(dirEntries, function(idx, entry) {
            var idHex = entry.slice(0, 4),
                id = littleEndian ? parseLittleEndian(idHex) : parseInt(idHex, 16),
                tagsToFindIdx = tagsToFind.indexOf(id),
                tagValHex, tagName, tagValLength;

            if (tagsToFindIdx >= 0) {
                tagName = TAG_INFO[id].name;
                tagValLength = TAG_INFO[id].bytes;
                tagValHex = entry.slice(TAG_VAL_OFFSET, TAG_VAL_OFFSET + (tagValLength * 2));
                vals[tagName] = littleEndian ? parseLittleEndian(tagValHex) : parseInt(tagValHex, 16);

                tagsToFind.splice(tagsToFindIdx, 1);
            }

            if (tagsToFind.length === 0) {
                return false;
            }
        });

        return vals;
    }

    qq.extend(this, {
        /**
         * Attempt to parse the EXIF header for the `Blob` associated with this instance.
         *
         * @returns {qq.Promise} To be fulfilled when the parsing is complete.
         * If successful, the parsed EXIF header as an object will be included.
         */
        parse: function() {
            var parser = new qq.Promise(),
                onParseFailure = function(message) {
                    log(qq.format("EXIF header parse failed: '{}' ", message));
                    parser.failure(message);
                };

            getApp1Offset().then(function(app1Offset) {
                log(qq.format("Moving forward with EXIF header parsing for '{}'", fileOrBlob.name === undefined ? "blob" : fileOrBlob.name));

                isLittleEndian(app1Offset).then(function(littleEndian) {

                    log(qq.format("EXIF Byte order is {} endian", littleEndian ? "little" : "big"));

                    getDirEntryCount(app1Offset, littleEndian).then(function(dirEntryCount) {

                        log(qq.format("Found {} APP1 directory entries", dirEntryCount));

                        getIfd(app1Offset, dirEntryCount).then(function(ifdHex) {
                            var dirEntries = getDirEntries(ifdHex),
                                tagValues = getTagValues(littleEndian, dirEntries);

                            log("Successfully parsed some EXIF tags");

                            parser.success(tagValues);
                        }, onParseFailure);
                    }, onParseFailure);
                }, onParseFailure);
            }, onParseFailure);

            return parser;
        }
    });

};

/*globals qq */
qq.Identify = function(fileOrBlob, log) {
    "use strict";

    function isIdentifiable(magicBytes, questionableBytes) {
        var identifiable = false,
            magicBytesEntries = [].concat(magicBytes);

        qq.each(magicBytesEntries, function(idx, magicBytesArrayEntry) {
            if (questionableBytes.indexOf(magicBytesArrayEntry) === 0) {
                identifiable = true;
                return false;
            }
        });

        return identifiable;
    }

    qq.extend(this, {
        /**
         * Determines if a Blob can be displayed natively in the current browser.  This is done by reading magic
         * bytes in the beginning of the file, so this is an asynchronous operation.  Before we attempt to read the
         * file, we will examine the blob's type attribute to save CPU cycles.
         *
         * @returns {qq.Promise} Promise that is fulfilled when identification is complete.
         * If successful, the MIME string is passed to the success handler.
         */
        isPreviewable: function() {
            var self = this,
                identifier = new qq.Promise(),
                previewable = false,
                name = fileOrBlob.name === undefined ? "blob" : fileOrBlob.name;

            log(qq.format("Attempting to determine if {} can be rendered in this browser", name));

            log("First pass: check type attribute of blob object.");

            if (this.isPreviewableSync()) {
                log("Second pass: check for magic bytes in file header.");

                qq.readBlobToHex(fileOrBlob, 0, 4).then(function(hex) {
                    qq.each(self.PREVIEWABLE_MIME_TYPES, function(mime, bytes) {
                        if (isIdentifiable(bytes, hex)) {
                            // Safari is the only supported browser that can deal with TIFFs natively,
                            // so, if this is a TIFF and the UA isn't Safari, declare this file "non-previewable".
                            if (mime !== "image/tiff" || qq.supportedFeatures.tiffPreviews) {
                                previewable = true;
                                identifier.success(mime);
                            }

                            return false;
                        }
                    });

                    log(qq.format("'{}' is {} able to be rendered in this browser", name, previewable ? "" : "NOT"));

                    if (!previewable) {
                        identifier.failure();
                    }
                },
                function() {
                    log("Error reading file w/ name '" + name + "'.  Not able to be rendered in this browser.");
                    identifier.failure();
                });
            }
            else {
                identifier.failure();
            }

            return identifier;
        },

        /**
         * Determines if a Blob can be displayed natively in the current browser.  This is done by checking the
         * blob's type attribute.  This is a synchronous operation, useful for situations where an asynchronous operation
         * would be challenging to support.  Note that the blob's type property is not as accurate as reading the
         * file's magic bytes.
         *
         * @returns {Boolean} true if the blob can be rendered in the current browser
         */
        isPreviewableSync: function() {
            var fileMime = fileOrBlob.type,
                // Assumption: This will only ever be executed in browsers that support `Object.keys`.
                isRecognizedImage = qq.indexOf(Object.keys(this.PREVIEWABLE_MIME_TYPES), fileMime) >= 0,
                previewable = false,
                name = fileOrBlob.name === undefined ? "blob" : fileOrBlob.name;

            if (isRecognizedImage) {
                if (fileMime === "image/tiff") {
                    previewable = qq.supportedFeatures.tiffPreviews;
                }
                else {
                    previewable = true;
                }
            }

            !previewable && log(name + " is not previewable in this browser per the blob's type attr");

            return previewable;
        }
    });
};

qq.Identify.prototype.PREVIEWABLE_MIME_TYPES = {
    "image/jpeg": "ffd8ff",
    "image/gif": "474946",
    "image/png": "89504e",
    "image/bmp": "424d",
    "image/tiff": ["49492a00", "4d4d002a"]
};

/*globals qq*/
/**
 * Attempts to validate an image, wherever possible.
 *
 * @param blob File or Blob representing a user-selecting image.
 * @param log Uses this to post log messages to the console.
 * @constructor
 */
qq.ImageValidation = function(blob, log) {
    "use strict";

    /**
     * @param limits Object with possible image-related limits to enforce.
     * @returns {boolean} true if at least one of the limits has a non-zero value
     */
    function hasNonZeroLimits(limits) {
        var atLeastOne = false;

        qq.each(limits, function(limit, value) {
            if (value > 0) {
                atLeastOne = true;
                return false;
            }
        });

        return atLeastOne;
    }

    /**
     * @returns {qq.Promise} The promise is a failure if we can't obtain the width & height.
     * Otherwise, `success` is called on the returned promise with an object containing
     * `width` and `height` properties.
     */
    function getWidthHeight() {
        var sizeDetermination = new qq.Promise();

        new qq.Identify(blob, log).isPreviewable().then(function() {
            var image = new Image(),
                url = window.URL && window.URL.createObjectURL ? window.URL :
                      window.webkitURL && window.webkitURL.createObjectURL ? window.webkitURL :
                      null;

            if (url) {
                image.onerror = function() {
                    log("Cannot determine dimensions for image.  May be too large.", "error");
                    sizeDetermination.failure();
                };

                image.onload = function() {
                    sizeDetermination.success({
                        width: this.width,
                        height: this.height
                    });
                };

                image.src = url.createObjectURL(blob);
            }
            else {
                log("No createObjectURL function available to generate image URL!", "error");
                sizeDetermination.failure();
            }
        }, sizeDetermination.failure);

        return sizeDetermination;
    }

    /**
     *
     * @param limits Object with possible image-related limits to enforce.
     * @param dimensions Object containing `width` & `height` properties for the image to test.
     * @returns {String || undefined} The name of the failing limit.  Undefined if no failing limits.
     */
    function getFailingLimit(limits, dimensions) {
        var failingLimit;

        qq.each(limits, function(limitName, limitValue) {
            if (limitValue > 0) {
                var limitMatcher = /(max|min)(Width|Height)/.exec(limitName),
                    dimensionPropName = limitMatcher[2].charAt(0).toLowerCase() + limitMatcher[2].slice(1),
                    actualValue = dimensions[dimensionPropName];

                /*jshint -W015*/
                switch (limitMatcher[1]) {
                    case "min":
                        if (actualValue < limitValue) {
                            failingLimit = limitName;
                            return false;
                        }
                        break;
                    case "max":
                        if (actualValue > limitValue) {
                            failingLimit = limitName;
                            return false;
                        }
                        break;
                }
            }
        });

        return failingLimit;
    }

    /**
     * Validate the associated blob.
     *
     * @param limits
     * @returns {qq.Promise} `success` is called on the promise is the image is valid or
     * if the blob is not an image, or if the image is not verifiable.
     * Otherwise, `failure` with the name of the failing limit.
     */
    this.validate = function(limits) {
        var validationEffort = new qq.Promise();

        log("Attempting to validate image.");

        if (hasNonZeroLimits(limits)) {
            getWidthHeight().then(function(dimensions) {
                var failingLimit = getFailingLimit(limits, dimensions);

                if (failingLimit) {
                    validationEffort.failure(failingLimit);
                }
                else {
                    validationEffort.success();
                }
            }, validationEffort.success);
        }
        else {
            validationEffort.success();
        }

        return validationEffort;
    };
};

/* globals qq */
/**
 * Module used to control populating the initial list of files.
 *
 * @constructor
 */
qq.Session = function(spec) {
    "use strict";

    var options = {
        endpoint: null,
        params: {},
        customHeaders: {},
        cors: {},
        addFileRecord: function(sessionData) {},
        log: function(message, level) {}
    };

    qq.extend(options, spec, true);

    function isJsonResponseValid(response) {
        if (qq.isArray(response)) {
            return true;
        }

        options.log("Session response is not an array.", "error");
    }

    function handleFileItems(fileItems, success, xhrOrXdr, promise) {
        var someItemsIgnored = false;

        success = success && isJsonResponseValid(fileItems);

        if (success) {
            qq.each(fileItems, function(idx, fileItem) {
                /* jshint eqnull:true */
                if (fileItem.uuid == null) {
                    someItemsIgnored = true;
                    options.log(qq.format("Session response item {} did not include a valid UUID - ignoring.", idx), "error");
                }
                else if (fileItem.name == null) {
                    someItemsIgnored = true;
                    options.log(qq.format("Session response item {} did not include a valid name - ignoring.", idx), "error");
                }
                else {
                    try {
                        options.addFileRecord(fileItem);
                        return true;
                    }
                    catch (err) {
                        someItemsIgnored = true;
                        options.log(err.message, "error");
                    }
                }

                return false;
            });
        }

        promise[success && !someItemsIgnored ? "success" : "failure"](fileItems, xhrOrXdr);
    }

    // Initiate a call to the server that will be used to populate the initial file list.
    // Returns a `qq.Promise`.
    this.refresh = function() {
        /*jshint indent:false */
        var refreshEffort = new qq.Promise(),
            refreshCompleteCallback = function(response, success, xhrOrXdr) {
                handleFileItems(response, success, xhrOrXdr, refreshEffort);
            },
            requesterOptions = qq.extend({}, options),
            requester = new qq.SessionAjaxRequester(
                qq.extend(requesterOptions, {onComplete: refreshCompleteCallback})
            );

        requester.queryServer();

        return refreshEffort;
    };
};

/*globals qq, XMLHttpRequest*/
/**
 * Thin module used to send GET requests to the server, expecting information about session
 * data used to initialize an uploader instance.
 *
 * @param spec Various options used to influence the associated request.
 * @constructor
 */
qq.SessionAjaxRequester = function(spec) {
    "use strict";

    var requester,
        options = {
            endpoint: null,
            customHeaders: {},
            params: {},
            cors: {
                expected: false,
                sendCredentials: false
            },
            onComplete: function(response, success, xhrOrXdr) {},
            log: function(str, level) {}
        };

    qq.extend(options, spec);

    function onComplete(id, xhrOrXdr, isError) {
        var response = null;

        /* jshint eqnull:true */
        if (xhrOrXdr.responseText != null) {
            try {
                response = qq.parseJson(xhrOrXdr.responseText);
            }
            catch (err) {
                options.log("Problem parsing session response: " + err.message, "error");
                isError = true;
            }
        }

        options.onComplete(response, !isError, xhrOrXdr);
    }

    requester = qq.extend(this, new qq.AjaxRequester({
        acceptHeader: "application/json",
        validMethods: ["GET"],
        method: "GET",
        endpointStore: {
            get: function() {
                return options.endpoint;
            }
        },
        customHeaders: options.customHeaders,
        log: options.log,
        onComplete: onComplete,
        cors: options.cors
    }));

    qq.extend(this, {
        queryServer: function() {
            var params = qq.extend({}, options.params);

            options.log("Session query request.");

            requester.initTransport("sessionRefresh")
                .withParams(params)
                .withCacheBuster()
                .send();
        }
    });
};

/* globals qq */
/**
 * Module that handles support for existing forms.
 *
 * @param options Options passed from the integrator-supplied options related to form support.
 * @param startUpload Callback to invoke when files "stored" should be uploaded.
 * @param log Proxy for the logger
 * @constructor
 */
qq.FormSupport = function(options, startUpload, log) {
    "use strict";
    var self  = this,
        interceptSubmit = options.interceptSubmit,
        formEl = options.element,
        autoUpload = options.autoUpload;

    // Available on the public API associated with this module.
    qq.extend(this, {
        // To be used by the caller to determine if the endpoint will be determined by some processing
        // that occurs in this module, such as if the form has an action attribute.
        // Ignore if `attachToForm === false`.
        newEndpoint: null,

        // To be used by the caller to determine if auto uploading should be allowed.
        // Ignore if `attachToForm === false`.
        newAutoUpload: autoUpload,

        // true if a form was detected and is being tracked by this module
        attachedToForm: false,

        // Returns an object with names and values for all valid form elements associated with the attached form.
        getFormInputsAsObject: function() {
            /* jshint eqnull:true */
            if (formEl == null) {
                return null;
            }

            return self._form2Obj(formEl);
        }
    });

    // If the form contains an action attribute, this should be the new upload endpoint.
    function determineNewEndpoint(formEl) {
        if (formEl.getAttribute("action")) {
            self.newEndpoint = formEl.getAttribute("action");
        }
    }

    // Return true only if the form is valid, or if we cannot make this determination.
    // If the form is invalid, ensure invalid field(s) are highlighted in the UI.
    function validateForm(formEl, nativeSubmit) {
        if (formEl.checkValidity && !formEl.checkValidity()) {
            log("Form did not pass validation checks - will not upload.", "error");
            nativeSubmit();
        }
        else {
            return true;
        }
    }

    // Intercept form submit attempts, unless the integrator has told us not to do this.
    function maybeUploadOnSubmit(formEl) {
        var nativeSubmit = formEl.submit;

        // Intercept and squelch submit events.
        qq(formEl).attach("submit", function(event) {
            event = event || window.event;

            if (event.preventDefault) {
                event.preventDefault();
            }
            else {
                event.returnValue = false;
            }

            validateForm(formEl, nativeSubmit) && startUpload();
        });

        // The form's `submit()` function may be called instead (i.e. via jQuery.submit()).
        // Intercept that too.
        formEl.submit = function() {
            validateForm(formEl, nativeSubmit) && startUpload();
        };
    }

    // If the element value passed from the uploader is a string, assume it is an element ID - select it.
    // The rest of the code in this module depends on this being an HTMLElement.
    function determineFormEl(formEl) {
        if (formEl) {
            if (qq.isString(formEl)) {
                formEl = document.getElementById(formEl);
            }

            if (formEl) {
                log("Attaching to form element.");
                determineNewEndpoint(formEl);
                interceptSubmit && maybeUploadOnSubmit(formEl);
            }
        }

        return formEl;
    }

    formEl = determineFormEl(formEl);
    this.attachedToForm = !!formEl;
};

qq.extend(qq.FormSupport.prototype, {
    // Converts all relevant form fields to key/value pairs.  This is meant to mimic the data a browser will
    // construct from a given form when the form is submitted.
    _form2Obj: function(form) {
        "use strict";
        var obj = {},
            notIrrelevantType = function(type) {
                var irrelevantTypes = [
                    "button",
                    "image",
                    "reset",
                    "submit"
                ];

                return qq.indexOf(irrelevantTypes, type.toLowerCase()) < 0;
            },
            radioOrCheckbox = function(type) {
                return qq.indexOf(["checkbox", "radio"], type.toLowerCase()) >= 0;
            },
            ignoreValue = function(el) {
                if (radioOrCheckbox(el.type) && !el.checked) {
                    return true;
                }

                return el.disabled && el.type.toLowerCase() !== "hidden";
            },
            selectValue = function(select) {
                var value = null;

                qq.each(qq(select).children(), function(idx, child) {
                    if (child.tagName.toLowerCase() === "option" && child.selected) {
                        value = child.value;
                        return false;
                    }
                });

                return value;
            };

        qq.each(form.elements, function(idx, el) {
            if ((qq.isInput(el, true) || el.tagName.toLowerCase() === "textarea") &&
                notIrrelevantType(el.type) &&
                !ignoreValue(el)) {

                obj[el.name] = el.value;
            }
            else if (el.tagName.toLowerCase() === "select" && !ignoreValue(el)) {
                var value = selectValue(el);

                if (value !== null) {
                    obj[el.name] = value;
                }
            }
        });

        return obj;
    }
});

/* globals qq, ExifRestorer */
/**
 * Controls generation of scaled images based on a reference image encapsulated in a `File` or `Blob`.
 * Scaled images are generated and converted to blobs on-demand.
 * Multiple scaled images per reference image with varying sizes and other properties are supported.
 *
 * @param spec Information about the scaled images to generate.
 * @param log Logger instance
 * @constructor
 */
qq.Scaler = function(spec, log) {
    "use strict";

    var self = this,
        customResizeFunction = spec.customResizer,
        includeOriginal = spec.sendOriginal,
        orient = spec.orient,
        defaultType = spec.defaultType,
        defaultQuality = spec.defaultQuality / 100,
        failedToScaleText = spec.failureText,
        includeExif = spec.includeExif,
        sizes = this._getSortedSizes(spec.sizes);

    // Revealed API for instances of this module
    qq.extend(this, {
        // If no targeted sizes have been declared or if this browser doesn't support
        // client-side image preview generation, there is no scaling to do.
        enabled: qq.supportedFeatures.scaling && sizes.length > 0,

        getFileRecords: function(originalFileUuid, originalFileName, originalBlobOrBlobData) {
            var self = this,
                records = [],
                originalBlob = originalBlobOrBlobData.blob ? originalBlobOrBlobData.blob : originalBlobOrBlobData,
                identifier = new qq.Identify(originalBlob, log);

            // If the reference file cannot be rendered natively, we can't create scaled versions.
            if (identifier.isPreviewableSync()) {
                // Create records for each scaled version & add them to the records array, smallest first.
                qq.each(sizes, function(idx, sizeRecord) {
                    var outputType = self._determineOutputType({
                        defaultType: defaultType,
                        requestedType: sizeRecord.type,
                        refType: originalBlob.type
                    });

                    records.push({
                        uuid: qq.getUniqueId(),
                        name: self._getName(originalFileName, {
                            name: sizeRecord.name,
                            type: outputType,
                            refType: originalBlob.type
                        }),
                        blob: new qq.BlobProxy(originalBlob,
                        qq.bind(self._generateScaledImage, self, {
                            customResizeFunction: customResizeFunction,
                            maxSize: sizeRecord.maxSize,
                            orient: orient,
                            type: outputType,
                            quality: defaultQuality,
                            failedText: failedToScaleText,
                            includeExif: includeExif,
                            log: log
                        }))
                    });
                });

                records.push({
                    uuid: originalFileUuid,
                    name: originalFileName,
                    size: originalBlob.size,
                    blob: includeOriginal ? originalBlob : null
                });
            }
            else {
                records.push({
                    uuid: originalFileUuid,
                    name: originalFileName,
                    size: originalBlob.size,
                    blob: originalBlob
                });
            }

            return records;
        },

        handleNewFile: function(file, name, uuid, size, fileList, batchId, uuidParamName, api) {
            var self = this,
                buttonId = file.qqButtonId || (file.blob && file.blob.qqButtonId),
                scaledIds = [],
                originalId = null,
                addFileToHandler = api.addFileToHandler,
                uploadData = api.uploadData,
                paramsStore = api.paramsStore,
                proxyGroupId = qq.getUniqueId();

            qq.each(self.getFileRecords(uuid, name, file), function(idx, record) {
                var blobSize = record.size,
                    id;

                if (record.blob instanceof qq.BlobProxy) {
                    blobSize = -1;
                }

                id = uploadData.addFile({
                    uuid: record.uuid,
                    name: record.name,
                    size: blobSize,
                    batchId: batchId,
                    proxyGroupId: proxyGroupId
                });

                if (record.blob instanceof qq.BlobProxy) {
                    scaledIds.push(id);
                }
                else {
                    originalId = id;
                }

                if (record.blob) {
                    addFileToHandler(id, record.blob);
                    fileList.push({id: id, file: record.blob});
                }
                else {
                    uploadData.setStatus(id, qq.status.REJECTED);
                }
            });

            // If we are potentially uploading an original file and some scaled versions,
            // ensure the scaled versions include reference's to the parent's UUID and size
            // in their associated upload requests.
            if (originalId !== null) {
                qq.each(scaledIds, function(idx, scaledId) {
                    var params = {
                        qqparentuuid: uploadData.retrieve({id: originalId}).uuid,
                        qqparentsize: uploadData.retrieve({id: originalId}).size
                    };

                    // Make sure the UUID for each scaled image is sent with the upload request,
                    // to be consistent (since we may need to ensure it is sent for the original file as well).
                    params[uuidParamName] = uploadData.retrieve({id: scaledId}).uuid;

                    uploadData.setParentId(scaledId, originalId);
                    paramsStore.addReadOnly(scaledId, params);
                });

                // If any scaled images are tied to this parent image, be SURE we send its UUID as an upload request
                // parameter as well.
                if (scaledIds.length) {
                    (function() {
                        var param = {};
                        param[uuidParamName] = uploadData.retrieve({id: originalId}).uuid;
                        paramsStore.addReadOnly(originalId, param);
                    }());
                }
            }
        }
    });
};

qq.extend(qq.Scaler.prototype, {
    scaleImage: function(id, specs, api) {
        "use strict";

        if (!qq.supportedFeatures.scaling) {
            throw new qq.Error("Scaling is not supported in this browser!");
        }

        var scalingEffort = new qq.Promise(),
            log = api.log,
            file = api.getFile(id),
            uploadData = api.uploadData.retrieve({id: id}),
            name = uploadData && uploadData.name,
            uuid = uploadData && uploadData.uuid,
            scalingOptions = {
                customResizer: specs.customResizer,
                sendOriginal: false,
                orient: specs.orient,
                defaultType: specs.type || null,
                defaultQuality: specs.quality,
                failedToScaleText: "Unable to scale",
                sizes: [{name: "", maxSize: specs.maxSize}]
            },
            scaler = new qq.Scaler(scalingOptions, log);

        if (!qq.Scaler || !qq.supportedFeatures.imagePreviews || !file) {
            scalingEffort.failure();

            log("Could not generate requested scaled image for " + id + ".  " +
                "Scaling is either not possible in this browser, or the file could not be located.", "error");
        }
        else {
            (qq.bind(function() {
                // Assumption: There will never be more than one record
                var record = scaler.getFileRecords(uuid, name, file)[0];

                if (record && record.blob instanceof qq.BlobProxy) {
                    record.blob.create().then(scalingEffort.success, scalingEffort.failure);
                }
                else {
                    log(id + " is not a scalable image!", "error");
                    scalingEffort.failure();
                }
            }, this)());
        }

        return scalingEffort;
    },

    // NOTE: We cannot reliably determine at this time if the UA supports a specific MIME type for the target format.
    // image/jpeg and image/png are the only safe choices at this time.
    _determineOutputType: function(spec) {
        "use strict";

        var requestedType = spec.requestedType,
            defaultType = spec.defaultType,
            referenceType = spec.refType;

        // If a default type and requested type have not been specified, this should be a
        // JPEG if the original type is a JPEG, otherwise, a PNG.
        if (!defaultType && !requestedType) {
            if (referenceType !== "image/jpeg") {
                return "image/png";
            }
            return referenceType;
        }

        // A specified default type is used when a requested type is not specified.
        if (!requestedType) {
            return defaultType;
        }

        // If requested type is specified, use it, as long as this recognized type is supported by the current UA
        if (qq.indexOf(Object.keys(qq.Identify.prototype.PREVIEWABLE_MIME_TYPES), requestedType) >= 0) {
            if (requestedType === "image/tiff") {
                return qq.supportedFeatures.tiffPreviews ? requestedType : defaultType;
            }

            return requestedType;
        }

        return defaultType;
    },

    // Get a file name for a generated scaled file record, based on the provided scaled image description
    _getName: function(originalName, scaledVersionProperties) {
        "use strict";

        var startOfExt = originalName.lastIndexOf("."),
            versionType = scaledVersionProperties.type || "image/png",
            referenceType = scaledVersionProperties.refType,
            scaledName = "",
            scaledExt = qq.getExtension(originalName),
            nameAppendage = "";

        if (scaledVersionProperties.name && scaledVersionProperties.name.trim().length) {
            nameAppendage = " (" + scaledVersionProperties.name + ")";
        }

        if (startOfExt >= 0) {
            scaledName = originalName.substr(0, startOfExt);

            if (referenceType !== versionType) {
                scaledExt = versionType.split("/")[1];
            }

            scaledName += nameAppendage + "." + scaledExt;
        }
        else {
            scaledName = originalName + nameAppendage;
        }

        return scaledName;
    },

    // We want the smallest scaled file to be uploaded first
    _getSortedSizes: function(sizes) {
        "use strict";

        sizes = qq.extend([], sizes);

        return sizes.sort(function(a, b) {
            if (a.maxSize > b.maxSize) {
                return 1;
            }
            if (a.maxSize < b.maxSize) {
                return -1;
            }
            return 0;
        });
    },

    _generateScaledImage: function(spec, sourceFile) {
        "use strict";

        var self = this,
            customResizeFunction = spec.customResizeFunction,
            log = spec.log,
            maxSize = spec.maxSize,
            orient = spec.orient,
            type = spec.type,
            quality = spec.quality,
            failedText = spec.failedText,
            includeExif = spec.includeExif && sourceFile.type === "image/jpeg" && type === "image/jpeg",
            scalingEffort = new qq.Promise(),
            imageGenerator = new qq.ImageGenerator(log),
            canvas = document.createElement("canvas");

        log("Attempting to generate scaled version for " + sourceFile.name);

        imageGenerator.generate(sourceFile, canvas, {maxSize: maxSize, orient: orient, customResizeFunction: customResizeFunction}).then(function() {
            var scaledImageDataUri = canvas.toDataURL(type, quality),
                signalSuccess = function() {
                    log("Success generating scaled version for " + sourceFile.name);
                    var blob = qq.dataUriToBlob(scaledImageDataUri);
                    scalingEffort.success(blob);
                };

            if (includeExif) {
                self._insertExifHeader(sourceFile, scaledImageDataUri, log).then(function(scaledImageDataUriWithExif) {
                    scaledImageDataUri = scaledImageDataUriWithExif;
                    signalSuccess();
                },
                function() {
                    log("Problem inserting EXIF header into scaled image.  Using scaled image w/out EXIF data.", "error");
                    signalSuccess();
                });
            }
            else {
                signalSuccess();
            }
        }, function() {
            log("Failed attempt to generate scaled version for " + sourceFile.name, "error");
            scalingEffort.failure(failedText);
        });

        return scalingEffort;
    },

    // Attempt to insert the original image's EXIF header into a scaled version.
    _insertExifHeader: function(originalImage, scaledImageDataUri, log) {
        "use strict";

        var reader = new FileReader(),
            insertionEffort = new qq.Promise(),
            originalImageDataUri = "";

        reader.onload = function() {
            originalImageDataUri = reader.result;
            insertionEffort.success(qq.ExifRestorer.restore(originalImageDataUri, scaledImageDataUri));
        };

        reader.onerror = function() {
            log("Problem reading " + originalImage.name + " during attempt to transfer EXIF data to scaled version.", "error");
            insertionEffort.failure();
        };

        reader.readAsDataURL(originalImage);

        return insertionEffort;
    },

    _dataUriToBlob: function(dataUri) {
        "use strict";

        var byteString, mimeString, arrayBuffer, intArray;

        // convert base64 to raw binary data held in a string
        if (dataUri.split(",")[0].indexOf("base64") >= 0) {
            byteString = atob(dataUri.split(",")[1]);
        }
        else {
            byteString = decodeURI(dataUri.split(",")[1]);
        }

        // extract the MIME
        mimeString = dataUri.split(",")[0]
            .split(":")[1]
            .split(";")[0];

        // write the bytes of the binary string to an ArrayBuffer
        arrayBuffer = new ArrayBuffer(byteString.length);
        intArray = new Uint8Array(arrayBuffer);
        qq.each(byteString, function(idx, character) {
            intArray[idx] = character.charCodeAt(0);
        });

        return this._createBlob(arrayBuffer, mimeString);
    },

    _createBlob: function(data, mime) {
        "use strict";

        var BlobBuilder = window.BlobBuilder ||
                window.WebKitBlobBuilder ||
                window.MozBlobBuilder ||
                window.MSBlobBuilder,
            blobBuilder = BlobBuilder && new BlobBuilder();

        if (blobBuilder) {
            blobBuilder.append(data);
            return blobBuilder.getBlob(mime);
        }
        else {
            return new Blob([data], {type: mime});
        }
    }
});

//Based on MinifyJpeg
//http://elicon.blog57.fc2.com/blog-entry-206.html

qq.ExifRestorer = (function()
{
   
	var ExifRestorer = {};
	 
    ExifRestorer.KEY_STR = "ABCDEFGHIJKLMNOP" +
                         "QRSTUVWXYZabcdef" +
                         "ghijklmnopqrstuv" +
                         "wxyz0123456789+/" +
                         "=";

    ExifRestorer.encode64 = function(input)
    {
        var output = "",
            chr1, chr2, chr3 = "",
            enc1, enc2, enc3, enc4 = "",
            i = 0;

        do {
            chr1 = input[i++];
            chr2 = input[i++];
            chr3 = input[i++];

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
               enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
               enc4 = 64;
            }

            output = output +
               this.KEY_STR.charAt(enc1) +
               this.KEY_STR.charAt(enc2) +
               this.KEY_STR.charAt(enc3) +
               this.KEY_STR.charAt(enc4);
            chr1 = chr2 = chr3 = "";
            enc1 = enc2 = enc3 = enc4 = "";
        } while (i < input.length);

        return output;
    };
    
    ExifRestorer.restore = function(origFileBase64, resizedFileBase64)
    {
        var expectedBase64Header = "data:image/jpeg;base64,";

        if (!origFileBase64.match(expectedBase64Header))
        {
        	return resizedFileBase64;
        }       
        
        var rawImage = this.decode64(origFileBase64.replace(expectedBase64Header, ""));
        var segments = this.slice2Segments(rawImage);
                
        var image = this.exifManipulation(resizedFileBase64, segments);
        
        return expectedBase64Header + this.encode64(image);
        
    };


    ExifRestorer.exifManipulation = function(resizedFileBase64, segments)
    {
            var exifArray = this.getExifArray(segments),
                newImageArray = this.insertExif(resizedFileBase64, exifArray),
                aBuffer = new Uint8Array(newImageArray);

            return aBuffer;
    };


    ExifRestorer.getExifArray = function(segments)
    {
            var seg;
            for (var x = 0; x < segments.length; x++)
            {
                seg = segments[x];
                if (seg[0] == 255 & seg[1] == 225) //(ff e1)
                {
                    return seg;
                }
            }
            return [];
    };


    ExifRestorer.insertExif = function(resizedFileBase64, exifArray)
    {
            var imageData = resizedFileBase64.replace("data:image/jpeg;base64,", ""),
                buf = this.decode64(imageData),
                separatePoint = buf.indexOf(255,3),
                mae = buf.slice(0, separatePoint),
                ato = buf.slice(separatePoint),
                array = mae;

            array = array.concat(exifArray);
            array = array.concat(ato);
           return array;
    };


    
    ExifRestorer.slice2Segments = function(rawImageArray)
    {
        var head = 0,
            segments = [];

        while (1)
        {
            if (rawImageArray[head] == 255 & rawImageArray[head + 1] == 218){break;}
            if (rawImageArray[head] == 255 & rawImageArray[head + 1] == 216)
            {
                head += 2;
            }
            else
            {
                var length = rawImageArray[head + 2] * 256 + rawImageArray[head + 3],
                    endPoint = head + length + 2,
                    seg = rawImageArray.slice(head, endPoint);
                segments.push(seg);
                head = endPoint;
            }
            if (head > rawImageArray.length){break;}
        }

        return segments;
    };


    
    ExifRestorer.decode64 = function(input) 
    {
        var output = "",
            chr1, chr2, chr3 = "",
            enc1, enc2, enc3, enc4 = "",
            i = 0,
            buf = [];

        // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
        var base64test = /[^A-Za-z0-9\+\/\=]/g;
        if (base64test.exec(input)) {
            throw new Error("There were invalid base64 characters in the input text.  " +
                "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='");
        }
        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        do {
            enc1 = this.KEY_STR.indexOf(input.charAt(i++));
            enc2 = this.KEY_STR.indexOf(input.charAt(i++));
            enc3 = this.KEY_STR.indexOf(input.charAt(i++));
            enc4 = this.KEY_STR.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            buf.push(chr1);

            if (enc3 != 64) {
               buf.push(chr2);
            }
            if (enc4 != 64) {
               buf.push(chr3);
            }

            chr1 = chr2 = chr3 = "";
            enc1 = enc2 = enc3 = enc4 = "";

        } while (i < input.length);

        return buf;
    };

    
    return ExifRestorer;
})();

/* globals qq */
/**
 * Keeps a running tally of total upload progress for a batch of files.
 *
 * @param callback Invoked when total progress changes, passing calculated total loaded & total size values.
 * @param getSize Function that returns the size of a file given its ID
 * @constructor
 */
qq.TotalProgress = function(callback, getSize) {
    "use strict";

    var perFileProgress = {},
        totalLoaded = 0,
        totalSize = 0,

        lastLoadedSent = -1,
        lastTotalSent = -1,
        callbackProxy = function(loaded, total) {
            if (loaded !== lastLoadedSent || total !== lastTotalSent) {
                callback(loaded, total);
            }

            lastLoadedSent = loaded;
            lastTotalSent = total;
        },

        /**
         * @param failed Array of file IDs that have failed
         * @param retryable Array of file IDs that are retryable
         * @returns true if none of the failed files are eligible for retry
         */
        noRetryableFiles = function(failed, retryable) {
            var none = true;

            qq.each(failed, function(idx, failedId) {
                if (qq.indexOf(retryable, failedId) >= 0) {
                    none = false;
                    return false;
                }
            });

            return none;
        },

        onCancel = function(id) {
            updateTotalProgress(id, -1, -1);
            delete perFileProgress[id];
        },

        onAllComplete = function(successful, failed, retryable) {
            if (failed.length === 0 || noRetryableFiles(failed, retryable)) {
                callbackProxy(totalSize, totalSize);
                this.reset();
            }
        },

        onNew = function(id) {
            var size = getSize(id);

            // We might not know the size yet, such as for blob proxies
            if (size > 0) {
                updateTotalProgress(id, 0, size);
                perFileProgress[id] = {loaded: 0, total: size};
            }
        },

        /**
         * Invokes the callback with the current total progress of all files in the batch.  Called whenever it may
         * be appropriate to re-calculate and disseminate this data.
         *
         * @param id ID of a file that has changed in some important way
         * @param newLoaded New loaded value for this file.  -1 if this value should no longer be part of calculations
         * @param newTotal New total size of the file.  -1 if this value should no longer be part of calculations
         */
        updateTotalProgress = function(id, newLoaded, newTotal) {
            var oldLoaded = perFileProgress[id] ? perFileProgress[id].loaded : 0,
                oldTotal = perFileProgress[id] ? perFileProgress[id].total : 0;

            if (newLoaded === -1 && newTotal === -1) {
                totalLoaded -= oldLoaded;
                totalSize -= oldTotal;
            }
            else {
                if (newLoaded) {
                    totalLoaded += newLoaded - oldLoaded;
                }
                if (newTotal) {
                    totalSize += newTotal - oldTotal;
                }
            }

            callbackProxy(totalLoaded, totalSize);
        };

    qq.extend(this, {
        // Called when a batch of files has completed uploading.
        onAllComplete: onAllComplete,

        // Called when the status of a file has changed.
        onStatusChange: function(id, oldStatus, newStatus) {
            if (newStatus === qq.status.CANCELED || newStatus === qq.status.REJECTED) {
                onCancel(id);
            }
            else if (newStatus === qq.status.SUBMITTING) {
                onNew(id);
            }
        },

        // Called whenever the upload progress of an individual file has changed.
        onIndividualProgress: function(id, loaded, total) {
            updateTotalProgress(id, loaded, total);
            perFileProgress[id] = {loaded: loaded, total: total};
        },

        // Called whenever the total size of a file has changed, such as when the size of a generated blob is known.
        onNewSize: function(id) {
            onNew(id);
        },

        reset: function() {
            perFileProgress = {};
            totalLoaded = 0;
            totalSize = 0;
        }
    });
};

/*globals qq */
// Base handler for UI (FineUploader mode) events.
// Some more specific handlers inherit from this one.
qq.UiEventHandler = function(s, protectedApi) {
    "use strict";

    var disposer = new qq.DisposeSupport(),
        spec = {
            eventType: "click",
            attachTo: null,
            onHandled: function(target, event) {}
        };

    // This makes up the "public" API methods that will be accessible
    // to instances constructing a base or child handler
    qq.extend(this, {
        addHandler: function(element) {
            addHandler(element);
        },

        dispose: function() {
            disposer.dispose();
        }
    });

    function addHandler(element) {
        disposer.attach(element, spec.eventType, function(event) {
            // Only in IE: the `event` is a property of the `window`.
            event = event || window.event;

            // On older browsers, we must check the `srcElement` instead of the `target`.
            var target = event.target || event.srcElement;

            spec.onHandled(target, event);
        });
    }

    // These make up the "protected" API methods that children of this base handler will utilize.
    qq.extend(protectedApi, {
        getFileIdFromItem: function(item) {
            return item.qqFileId;
        },

        getDisposeSupport: function() {
            return disposer;
        }
    });

    qq.extend(spec, s);

    if (spec.attachTo) {
        addHandler(spec.attachTo);
    }
};

/* global qq */
qq.FileButtonsClickHandler = function(s) {
    "use strict";

    var inheritedInternalApi = {},
        spec = {
            templating: null,
            log: function(message, lvl) {},
            onDeleteFile: function(fileId) {},
            onCancel: function(fileId) {},
            onRetry: function(fileId) {},
            onPause: function(fileId) {},
            onContinue: function(fileId) {},
            onGetName: function(fileId) {}
        },
        buttonHandlers = {
            cancel: function(id) { spec.onCancel(id); },
            retry:  function(id) { spec.onRetry(id); },
            deleteButton: function(id) { spec.onDeleteFile(id); },
            pause: function(id) { spec.onPause(id); },
            continueButton: function(id) { spec.onContinue(id); }
        };

    function examineEvent(target, event) {
        qq.each(buttonHandlers, function(buttonType, handler) {
            var firstLetterCapButtonType = buttonType.charAt(0).toUpperCase() + buttonType.slice(1),
                fileId;

            if (spec.templating["is" + firstLetterCapButtonType](target)) {
                fileId = spec.templating.getFileId(target);
                qq.preventDefault(event);
                spec.log(qq.format("Detected valid file button click event on file '{}', ID: {}.", spec.onGetName(fileId), fileId));
                handler(fileId);
                return false;
            }
        });
    }

    qq.extend(spec, s);

    spec.eventType = "click";
    spec.onHandled = examineEvent;
    spec.attachTo = spec.templating.getFileList();

    qq.extend(this, new qq.UiEventHandler(spec, inheritedInternalApi));
};

/*globals qq */
// Child of FilenameEditHandler.  Used to detect click events on filename display elements.
qq.FilenameClickHandler = function(s) {
    "use strict";

    var inheritedInternalApi = {},
        spec = {
            templating: null,
            log: function(message, lvl) {},
            classes: {
                file: "qq-upload-file",
                editNameIcon: "qq-edit-filename-icon"
            },
            onGetUploadStatus: function(fileId) {},
            onGetName: function(fileId) {}
        };

    qq.extend(spec, s);

    // This will be called by the parent handler when a `click` event is received on the list element.
    function examineEvent(target, event) {
        if (spec.templating.isFileName(target) || spec.templating.isEditIcon(target)) {
            var fileId = spec.templating.getFileId(target),
                status = spec.onGetUploadStatus(fileId);

            // We only allow users to change filenames of files that have been submitted but not yet uploaded.
            if (status === qq.status.SUBMITTED) {
                spec.log(qq.format("Detected valid filename click event on file '{}', ID: {}.", spec.onGetName(fileId), fileId));
                qq.preventDefault(event);

                inheritedInternalApi.handleFilenameEdit(fileId, target, true);
            }
        }
    }

    spec.eventType = "click";
    spec.onHandled = examineEvent;

    qq.extend(this, new qq.FilenameEditHandler(spec, inheritedInternalApi));
};

/*globals qq */
// Child of FilenameEditHandler.  Used to detect focusin events on file edit input elements.
qq.FilenameInputFocusInHandler = function(s, inheritedInternalApi) {
    "use strict";

    var spec = {
            templating: null,
            onGetUploadStatus: function(fileId) {},
            log: function(message, lvl) {}
        };

    if (!inheritedInternalApi) {
        inheritedInternalApi = {};
    }

    // This will be called by the parent handler when a `focusin` event is received on the list element.
    function handleInputFocus(target, event) {
        if (spec.templating.isEditInput(target)) {
            var fileId = spec.templating.getFileId(target),
                status = spec.onGetUploadStatus(fileId);

            if (status === qq.status.SUBMITTED) {
                spec.log(qq.format("Detected valid filename input focus event on file '{}', ID: {}.", spec.onGetName(fileId), fileId));
                inheritedInternalApi.handleFilenameEdit(fileId, target);
            }
        }
    }

    spec.eventType = "focusin";
    spec.onHandled = handleInputFocus;

    qq.extend(spec, s);
    qq.extend(this, new qq.FilenameEditHandler(spec, inheritedInternalApi));
};

/*globals qq */
/**
 * Child of FilenameInputFocusInHandler.  Used to detect focus events on file edit input elements.  This child module is only
 * needed for UAs that do not support the focusin event.  Currently, only Firefox lacks this event.
 *
 * @param spec Overrides for default specifications
 */
qq.FilenameInputFocusHandler = function(spec) {
    "use strict";

    spec.eventType = "focus";
    spec.attachTo = null;

    qq.extend(this, new qq.FilenameInputFocusInHandler(spec, {}));
};

/*globals qq */
// Handles edit-related events on a file item (FineUploader mode).  This is meant to be a parent handler.
// Children will delegate to this handler when specific edit-related actions are detected.
qq.FilenameEditHandler = function(s, inheritedInternalApi) {
    "use strict";

    var spec = {
            templating: null,
            log: function(message, lvl) {},
            onGetUploadStatus: function(fileId) {},
            onGetName: function(fileId) {},
            onSetName: function(fileId, newName) {},
            onEditingStatusChange: function(fileId, isEditing) {}
        };

    function getFilenameSansExtension(fileId) {
        var filenameSansExt = spec.onGetName(fileId),
            extIdx = filenameSansExt.lastIndexOf(".");

        if (extIdx > 0) {
            filenameSansExt = filenameSansExt.substr(0, extIdx);
        }

        return filenameSansExt;
    }

    function getOriginalExtension(fileId) {
        var origName = spec.onGetName(fileId);
        return qq.getExtension(origName);
    }

    // Callback iff the name has been changed
    function handleNameUpdate(newFilenameInputEl, fileId) {
        var newName = newFilenameInputEl.value,
            origExtension;

        if (newName !== undefined && qq.trimStr(newName).length > 0) {
            origExtension = getOriginalExtension(fileId);

            if (origExtension !== undefined) {
                newName = newName + "." + origExtension;
            }

            spec.onSetName(fileId, newName);
        }

        spec.onEditingStatusChange(fileId, false);
    }

    // The name has been updated if the filename edit input loses focus.
    function registerInputBlurHandler(inputEl, fileId) {
        inheritedInternalApi.getDisposeSupport().attach(inputEl, "blur", function() {
            handleNameUpdate(inputEl, fileId);
        });
    }

    // The name has been updated if the user presses enter.
    function registerInputEnterKeyHandler(inputEl, fileId) {
        inheritedInternalApi.getDisposeSupport().attach(inputEl, "keyup", function(event) {

            var code = event.keyCode || event.which;

            if (code === 13) {
                handleNameUpdate(inputEl, fileId);
            }
        });
    }

    qq.extend(spec, s);

    spec.attachTo = spec.templating.getFileList();

    qq.extend(this, new qq.UiEventHandler(spec, inheritedInternalApi));

    qq.extend(inheritedInternalApi, {
        handleFilenameEdit: function(id, target, focusInput) {
            var newFilenameInputEl = spec.templating.getEditInput(id);

            spec.onEditingStatusChange(id, true);

            newFilenameInputEl.value = getFilenameSansExtension(id);

            if (focusInput) {
                newFilenameInputEl.focus();
            }

            registerInputBlurHandler(newFilenameInputEl, id);
            registerInputEnterKeyHandler(newFilenameInputEl, id);
        }
    });
};
if (typeof define === 'function' && define.amd) {
   define(function() {
       return qq;
   });
}
else if (typeof module !== 'undefined' && module.exports) {
   module.exports = qq;
}
else {
   global.qq = qq;
}
}(window));

/*! 2016-06-16 */
>>>>>>> cbd00582f3bd39ae9ea634f6a8872735d2d7f87d
