var loaderHtmlRound = '<div id="loading"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 50 50" xml:space="preserve"><path fill="#000" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z"><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite"></animateTransform></path></svg></div>';
var baseUrl=window.baseUrl;

//=============================================================// 
//============= Yosuke code ==============//

var udi_str = "";

//*********** Scan Barcode *********//
// Helper function called when the "Continue Scanning" button is clicked
function continueScanning() {
    if (picker) {
        continueButton.disabled = true;
        // Resume scanning
        picker.resumeScanning();
    }
}
// Configure the library and activate it with a license key -- simonlabi@hotmail.com 
//const licenseKey = "ASqOkxCcDs0nJ4cPHEBhSkQEBHR0AbRav3c2wNFJlDoRSmcwCH1jQf5g/h0tafm/kFtQ0r9F8wDJeVo1XWe/tt1wDDTzW1JnKFLlwm11WylwLBBMYgtiMOQVhGB3sz8HCEEcvcWmhh52NDTSxRAX1GCXgbAWf+AyRmWm5um4pJ0sETZZgXh+aGLPYw9jax9Fsj1phzRTdlYlFlgL133aj7EW+F3W+gYuD/GdL8PbLu5jrhVvYNRY9PzTLsop/kjjt+GsePhuGpl0EOCzNvMkogi56XBgVxgAdBUK/ZDzqHpXicYRiUwsX1tYbVYFwiKPkK1ZtQ02er/42CPVmEATqs9R+CpqKSQD7ATJ14tTweG8riSu9WjcvIzPKE8BiLwJTmRmB9GIwT58fqMbnYULF7oYi6wKFwF59exaMSO4RqkXzW5sP9jjJMmz6LifjaNuuvwHUD2x1wdSZBDZahaE9rVOetc80mMfkqmQugpt9IGNGcVg9q58Ntnxhf3FHfhD+NWjfDep+M8y6oU6+XlSVzzAgug86b/QPmoLkBjvjSBzB2EG/uaY1MRhJbUwagp98DDEDWOazv91RrAghYEpyqy0lS6JvfK1lV8j613cDmb2zPX6EKArDdlBIRtT0g2PJ5mdOsJzvL+CQHasrEwPbq0aV2Lx40rMVFsn3AwVL4RU/ovsaACQrbj3h1DvPoE1AA9aJ5Lfm7S/OjolsFNaWmKuqbgVstQYaeORCGqtzc50QdtL9tjPc5lhmp8KhHv/gLYEdAhfAbaRkAcQWoxUiSvPgWe/ziF0ldZr";

// Configure the library and activate it with a license key -- yosukeupworkharry@gmail.com 
const licenseKey = "AbqODSiUNt2RB3Hsi0T2QfFAYccUBGTYowVVZgsIdn/pZDjhcCCVCjZ6Vrg/fYxtmg8mmhZKluNeEypA10WIcsdJnOhre8oXiWPETpZnMGCcDGzqZBok5GJBonCR4KuLGKvHGB9itnevM6g7QlcBhYHCvcerNVW2A6eODg/8xM1db0g+OBKguQ8Zvo82oJzG2e2ls5jXAH/KZ3AiyW9uB5n1YJRk/hlNFeN3pLeQ4aaEXHtcqlens+5Y5L9OXxtSgnwkN2WNW7/sROuByaMq60jVah2DdK18uEZXOdEIxl68NaXcYNNVgLO6nIKVcaZuICPh+PTrolJIahpQB3ugP61a0zak8g6hbtvmFHEg6DQwNYY9z8jWCM19KW01RNCUvWd9PJ9NxKIo+svblKsU7UgVQyuEMZFkgYtmr5Osdy3Bs2O3KpvwOzChDaE9CqnTldE5HjYY9DnIrW0CcMhZv2BZxnJkpDT/hj6FhkLQnfkWCfcHsLNAHoST2T6l0pW34Ei3hlTGy0D5yrY8+e76ls6Ff4UJE2QlhbErTMnAv+PyslesK5cSmdYgppxVqCHK/JkOYUyf0PcLyVoaTnj6mtsc3N7bnnw8GNrhBdIYyWBqJeQBVmr9Uq4EsD0BAmn9nRwh/xN0XJ58JStCop/LVLsyzGigGURzHe5PW4CEFfmc0TVfKAz5elMFlrPVu5ISHZ/h5z+MpZw2QlJS9Ti/FPCgDRbdyc8vd/6nItgQiss/BJz84cqO0ALqb4iqarko95jSSaix7nHUAg/DwMFekFbzWnjrtGqo966M";

// Configure the library and activate it with a license key -- baymaxweb1985@hotmail.com 
//const licenseKey = "AWle9gGpH3R+PC4AGxZW9gwAfJjxMrHBkXFiVhxNwIouVAJNcVklvG9oCW1WA69paUOt9jBKXkq1Zf+0S2HA1/5OGgPfV57im1w2HLRUcoHoIlhxhyMHnyEeUYX+Ix0rna3zjIlLTSGSvEIZiBv/RsFtpx1jSfXdoJriKIgiUGZNqt5OP4XU/teVwVHqBBCiIoHZhjRfl8V8CxZvuOxnkw0rGajICrhlSUnpE4ZuZN1JZ6IGwEd4ghfI/as8uHFB4inqnjj8YACS1oTDVF8PusWA5xtX0PEYmI3vz/8t7uY2VohunLIF7scG76b/Ngqkml+q5DcGQs4iZC4V02eSWmWsD8/asHP02tovhxONWqC2lSkd+EnrceDqabjyk7G/W5fG473no63b9nyES9oahuUnY60jKFm0d0N4g1RYc4Qn0DIW21EwlQeo2u9gulQ96zFShIaY1fVCe8SVFio/eE4gXEvQI2r2bkWCZHT8SGV5E7OYIxSYg6xbE+OZMG8Co/wxPkkzbkRJiET0qeR/dSse13S2x2BDGq+Ve1o0VrGKUdFkCbvAAYxkLKlnzgrWFIqIl6VnuE1md++tMrPPIl2imxiRc/wiMJZ8Zbh6FnN9289dskElXHXD/gVXbNK8RKahD+oGGox2z8sPbUfQwLmtTG3oqTA1XykNYrhnXY8WgdVU9oVW1TjZld6LwedoZIukdyeHzf4Gyi8zpUIlZzVf2EJJ3A5sg+o8GIg7x6I5iAT3otOMRuWeYC5AGWAfy4kHzKmRtNac8DqA41BYIX2qo53YYmKACj9D";

// Configure the engine location, as explained on http://docs.scandit.com/stable/web/index.html
// const engineLocation = "build"; // the folder containing the engine
// or, if using a CDN:
const engineLocation = "https://cdn.jsdelivr.net/npm/scandit-sdk@4.x/build";

ScanditSDK.configure(licenseKey, { engineLocation: engineLocation });

const scannerContainer = document.getElementById("scandit-barcode-picker");
const resultContainer = document.getElementById("scandit-barcode-result");
const continueButton = document.getElementById("continue-scanning-button");
//continueButton.disabled = true;
//continueButton.hidden = true;
let picker;

var scan_count = 0;

///////////////////////////////////////////////////////////

function surchUdi(){
    udi_str = $("#udi").val();
    // Camera Scan
    $("#scan_udi").toggleClass("actived");
    if( $("#scan_udi").hasClass("actived") ){
        if(scan_count == 0){
            // Create & start the picker
            ScanditSDK.BarcodePicker.create(scannerContainer, {
                playSoundOnScan: true,
                vibrateOnScan: true
            })
            .then(barcodePicker => {
                picker = barcodePicker;
                // Create the settings object to be applied to the scanner
                const scanSettings = new ScanditSDK.ScanSettings({
                    enabledSymbologies: ["ean8", "ean13", "upca", "upce", "code128", "code39", "code93",
                        "itf", "qr", "data-matrix"],
                    codeDuplicateFilter: 1000
                });
                
                scanSettings.getSymbologySettings(ScanditSDK.Barcode.Symbology.CODE128).setActiveSymbolCountsRange(4,50);
                picker.applyScanSettings(scanSettings);
            
                // bracket (, )
                var parser = barcodePicker.createParserForFormat(ScanditSDK.Parser.DataFormat.GS1_AI);
                parser.setOptions({'outputHumanReadableString' : true});
                
                //picker.pauseScanning();
                 
                scan_count = 1; // once running camera
                // If a barcode is scanned, show it to the user and pause scanning
                // (scanning is resumed when the user clicks "Continue Scanning")
                picker.on("scan", scanResult => {
                    
                    //picker.pauseScanning();
                    
                    //bracket module
                    var barcodeData = scanResult.barcodes[0].data;
                    var result = barcodeData;
                    ///////////////////////
                    $("#scandit-barcode-result").text(result);
                    var index_type = 0;
                    if(result.indexOf("://") < 0){
                        index_type = result.indexOf(":");
                    }
                    var decoded_str = result.substring(index_type+1);
                    udi_str = decoded_str;
                    $("#udi").val(decoded_str);
                    
                });
                picker.on("scanError", error => {
                    alert(error.message);
                    console.error(error.message);
                });
                
            }).catch(error => {
                alert(error);
            });
            
        }else{
            picker.resumeScanning();
        }

        /// Getting GUDID 
        $("#scan_udi").text("Stop");
        get_GUDID(udi_str);
        
    }else{
        picker.pauseScanning();
        $('#loading').remove();
        $("#scan_udi").text("Scan");
        $(".camera-section").css('display', 'none');
        $("#alert_msg").remove();
        $("#udi").val("");
    }
    ///// end of camera
}
function reloadUdi(){
    $.ajax({
        url: baseUrl+"reloadudi",
        type: 'POST',
        dataType: 'json',
        /*beforeSend:function(){
            $('#results').prepend(loaderHtmlRound);
        },*/
        success: function(resp) {
            if(resp.status=='success') {
                $('#udiTable tbody').html(resp.html);
                //$('#loading').remove();
            } 
        }
    });
}
function get_GUDID(udi_str){
    console.log("start");
    if(udi_str.trim()){
        $.ajax({
            url: baseUrl+"getudi",
            type: 'POST',
            dataType: 'json',
            data: $('#frm_udi').serialize(),
            beforeSend:function(){
                $('#alert_msg').remove();
                $('#results').prepend(loaderHtmlRound);
            },
            success: function(resp) {
                if(resp.status=='success') {
                    $('#udiTable tbody').html(resp.html);
                    $('#loading').remove();
                    $("#udi").val("");
                    udi_str = "";                    
                    picker.resumeScanning();  // camera scan restart                    
                } else {
                    $('#loading').remove();
                    $('#frm_udi').before('<div id="alert_msg" class="alert alert-danger"><span class="close" data-dismiss="alert" aria-label="close">&times;</span>'+resp.error+'</div>');                    
                }
            },
            error: function(resp){
                $('#loading').remove();
                $('#frm_udi').before('<div id="alert_msg" class="alert alert-danger"><span class="close" data-dismiss="alert" aria-label="close">&times;</span>'+'GUDID Fatal Error'+'</div>');
            }
        });
    }else{
        $(".camera-section").css("display", "block");
    }
}

$(document).ready(function() {
    reloadUdi();
    $('#frm_udi').submit(function( event ) {return false;});
    $('#scan_udi').click(function( event ) {surchUdi();});
    $("#udi").keyup(function(e){
        //alert(event.keycode);
        //picker.pauseScanning();
        
        if( $("#scan_udi").hasClass("actived") ){
            
            $("#scan_udi").removeClass("actived");
            $("#scan_udi").text("Scan");    
            $(".camera-section").css("display", "none");
        }
         
        var code = e.keyCode || e.which;
        if(code == 13) {
            surchUdi();
        }
    });
    /////// Helpe in UDI scan
    $("#frm_udi .zmdi-help-outline").on("click", function(){
        $(".warning-background").css("display", "block");
        $(".warning-background .warning div").css("text-align", "center");
    });
    
    /////// warning 
    $(".newCase").on("click", function(event){
        event.preventDefault();
        $(".warning-background").css("display", "block");
    });
    
    $(".no").on("click", function(){
        $(".warning-background").css("display","none");
    });
    
});


