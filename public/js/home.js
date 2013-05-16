var seeAdsRef;
var clicksRef;

jQuery(document).ready(function ($) {
    setUpPresence();
    setUp($("#loadedAdId")[0].value);
});

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
        document.getElementById("connected_users").innerHTML = size(snapshot.val())
    });
}

function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for( var i=0; i < 50; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}

size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

// UPLOAD



// Custom example logic
$(function () {

    var uploader = new plupload.Uploader({

        runtimes: 'html5,browserplus',
        browse_button: 'pickfiles',
        container: 'container',
        max_file_size: '20mb',
        filters: [
            {title: "Image Files", extensions: "jpg,png"}
        ],
        url: ppi.baseUrl + 'files/upload/'
    });

    uploader.bind('Init', function (up, params) {
        //$('#filelist').html();
    });

    $('#pickfiles').click(function (e) {
        uploader.start();
        e.preventDefault();
    });

    uploader.init();
    uploader.bind('FilesAdded', function (up, files) {
        up.refresh(); // Reposition Flash/Silverlight
    });

    uploader.bind('UploadProgress', function (up, file) {
        $('#' + file.id + " b").html(file.percent + "%");
    });

    uploader.bind('Error', function (up, err) {

        if (err.message == 'File extension error.') {
            $('#filelist').append("<div>ERROR/div>");
        } else {
            $('#filelist').append("<div>Error: " + err.code +
                ", Mensaje: " + err.message +
                (err.file ? ", Archivo: " + err.file.name : "") +
                "</div>"
            );
        }

        up.refresh(); // Reposition Flash/Silverlight
    });

    uploader.bind('FileUploaded', function (up, file) {
        $('#' + file.id + " b").html("100%");

        // redirect to payment...
    });

});