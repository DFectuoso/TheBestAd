/*global Firebase:true usersRef:true */
/*jshint asi:true */

var seeAdsRef;
var clicksRef;

function seeAd(){
    seeAdsRef.transaction(function(currentRank) {
        return currentRank+1;
    });
}

function clickAd(){
    clicksRef.transaction(function(currentRank) {
        return currentRank+1;
    });
}

function setUp(adId){
    if(typeof seeAdsRef !== "undefined") seeAdsRef.off("value")
    if(typeof clicksRef !== "undefined") clicksRef.off("value")
    seeAdsRef = new Firebase('https://bestad.firebaseIO.com/see/' + adId);
    clicksRef = new Firebase('https://bestad.firebaseIO.com/clicks/' + adId);

    seeAdsRef.on('value', function(snapshot) {
        document.getElementById("ad_seen").innerHTML = snapshot.val()
    })

    clicksRef.on('value', function(snapshot) {
        document.getElementById("ad_clicks").innerHTML = snapshot.val()
    })
}

var makeid = function() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for( var i=0; i < 50; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
};

function setUpPresence(){
    var username = makeid();
    var total_connected = new Firebase('https://bestad.firebaseIO.com/total_connected');
    var onlineRef = new Firebase('https://bestad.firebaseIO.com/users/' + username + '/online');
    var connectedRef = new Firebase('https://bestad.firebaseIO.com/.info/connected');
    connectedRef.on('value', function(snap) {
        if (snap.val() === true) {
          // We're connected (or reconnected)!  Set up our presence state and tell
          // the server to remove it when we leave.
            onlineRef.onDisconnect().remove();
            onlineRef.set(true);
        }
    });

    usersRef = new Firebase('https://bestad.firebaseIO.com/users');
    usersRef.on('value', function(snapshot) {
        document.getElementById("connected_users").innerHTML = Object.keys(snapshot.val()).length;
    });
}

jQuery(document).ready(function ($) {
    setUpPresence();
    setUp($("#loadedAdId")[0].value);
});


var holder = document.getElementById('holder');

holder.ondragover = function (e) {
  e.preventDefault();
  this.className = 'hover';
};

holder.ondragend = function (e) {
  e.preventDefault();
  this.className = '';
};

holder.ondrop = function (e) {
  e.preventDefault();
  this.className = '';

  var file = e.dataTransfer.files[0],
      reader = new FileReader();
  reader.onload = function (event) {
    console.log(event.target);
    holder.style.background = 'url(' + event.target.result + ') no-repeat center';
  };
  console.log(file);
  reader.readAsDataURL(file);
};

