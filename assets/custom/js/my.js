/* 
 * ***************************************************************
 * Script : 
 * Version : 
 * Date :
 * Author : Pudyasto Adi W.
 * Email : mr.pudyasto@gmail.com
 * Description : 
 * ***************************************************************
 */
function toast(message,title,typemessage){
    if(!typemessage){
        typemessage = "info";
    }
    toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    toastr[typemessage](title,message);
}

function data_terbilang(bilangan) {
 if(bilangan==="" || Number(bilangan)<=0 || bilangan===undefined || isNaN(bilangan)){
     return "Nol Rupiah";
 }
 
 bilangan    = String(bilangan);
 var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
 var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
 var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');
 
 var panjang_bilangan = bilangan.length;
 
 /* pengujian panjang bilangan */
 if (panjang_bilangan > 15) {
   kaLimat = "Diluar Batas";
   return kaLimat;
 }
 
 /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
 for (i = 1; i <= panjang_bilangan; i++) {
   angka[i] = bilangan.substr(-(i),1);
 }
 
 i = 1;
 j = 0;
 kaLimat = "";
 
 
 /* mulai proses iterasi terhadap array angka */
 while (i <= panjang_bilangan) {
 
   subkaLimat = "";
   kata1 = "";
   kata2 = "";
   kata3 = "";
 
   /* untuk Ratusan */
   if (angka[i+2] != "0") {
     if (angka[i+2] == "1") {
       kata1 = "Seratus";
     } else {
       kata1 = kata[angka[i+2]] + " Ratus";
     }
   }
 
   /* untuk Puluhan atau Belasan */
   if (angka[i+1] != "0") {
     if (angka[i+1] == "1") {
       if (angka[i] == "0") {
         kata2 = "Sepuluh";
       } else if (angka[i] == "1") {
         kata2 = "Sebelas";
       } else {
         kata2 = kata[angka[i]] + " Belas";
       }
     } else {
       kata2 = kata[angka[i+1]] + " Puluh";
     }
   }
 
   /* untuk Satuan */
   if (angka[i] != "0") {
     if (angka[i+1] != "1") {
       kata3 = kata[angka[i]];
     }
   }
 
   /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
   if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
     subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
   }
 
   /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
   kaLimat = subkaLimat + kaLimat;
   i = i + 3;
   j = j + 1;
 
 }
 
 /* mengganti Satu Ribu jadi Seribu jika diperlukan */
 if ((angka[5] == "0") && (angka[6] == "0")) {
   kaLimat = kaLimat.replace("Satu Ribu","Seribu");
 }
 
 return kaLimat + "Rupiah";
}

function set_date(tahun,bulan,hari){   
    var tahun_awal = tahun;
    var bulan_awal = bulan;
    var hari_awal = hari;
    if(Number(bulan)>=12){
        tahun = (Number(bulan) / 12).toFixed(0);
        bulan = Number(bulan) - 12;
    }
    var d = new Date();
    
    if(Number(tahun) > d.getFullYear()){
        tahun = 0;
    }
    
    if(!(bulan)){
        bulan = d.getMonth() + 1;
    }else if(Number(bulan) === 0 && isNaN(bulan) === false){
        bulan = d.getMonth() + 1;
    }else if(Number(bulan) > 0 && isNaN(bulan) === false){
        bulan = ((d.getMonth() + 1) - Number(bulan));
    }else if(Number(bulan) > 12 && isNaN(bulan) === false){
        bulan = 12;
    }else{
        bulan = 12;
    }
    
    if(bulan===0){
        bulan = Number(bulan_awal);
    }else if(bulan<0){
        bulan = (Number(bulan_awal) + bulan) + 1;
        tahun = Number(tahun) + 1;
    }
    
    if(!(hari)){
        hari = d.getDate();
    }else if(Number(hari) === 0 && isNaN(bulan) === false){
        hari = d.getDate();
    }else if(Number(hari) > 0 && isNaN(bulan) === false){
        hari = d.getDate() - Number(hari);
    }else if(Number(hari) > 31 && isNaN(bulan) === false){
        hari = 31;
    }else{
        hari = 31;
    }
    
    if(hari===0){
        hari = Number(hari_awal);
    }else if(hari<0){
        hari = Number(hari_awal) + hari;
        bulan = Number(bulan) + 1;
    }
    
    
    var res = d.setFullYear(d.getFullYear() - Number(tahun));
    var newyear = new Date(res);
    var resdate =  zero_fill(Number(hari),"00") + "-" + zero_fill(Number(bulan),"00") + "-" + zero_fill(newyear.getFullYear(),"0000");
//    console.log(resdate);
    return resdate;
}

function zero_fill(number, pad){
    var str = "" + number;
    var res = pad.substring(0, pad.length - str.length) +""+ str;
    return res;
}

var substringMatcher = function(strs) {
    return function findMatches(q, cb) {
      var matches, substringRegex;

      // an array that will be populated with substring matches
      matches = [];

      // regex used to determine if a string contains the substring `q`
      substrRegex = new RegExp(q, 'i');

      // iterate through the pool of strings and for any string that
      // contains the substring `q`, add it to the `matches` array
      $.each(strs, function(i, str) {
        if (substrRegex.test(str)) {
          matches.push(str);
        }
      });

      cb(matches);
    };
  };

// load a locale
numeral.register('locale', 'id', {
    delimiters: {
        thousands: '.',
        decimal: ','
    },
    abbreviations: {
        thousand: 'k',
        million: 'm',
        billion: 'b',
        trillion: 't'
    },
    ordinal : function (number) {
        return number === 1 ? 'Rp.' : '-';
    },
    currency: {
        symbol: 'Rp.'
    }
});

// switch between locales
numeral.locale('id');

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function getRandomColorRGB() {
    var code1 = Math.floor(Math.random() * 256);
    var code2 = Math.floor(Math.random() * 256);
    var code3 = Math.floor(Math.random() * 256);
    var color = 'rgb('+code1+','+code2+','+code3+')';
    return color;
}

var bulan = ["Nama Bulan","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
var bulan_short = ["Nama Bulan","Jan","Feb","Mar","Apr","Mei","Juni","Juli","Agt","Sept","Okt","Nov","Des"];

function tgl_id_short(param){
    if(param===null || param===""){
        return "";
    }
    var yyyy = param.substring(0, 4);
    var mm = param.substring(5, 7);
    var dd = param.substring(8, 10);
    var hh = param.substring(10, 20);
    return dd + " " + bulan_short[Number(mm)] + " " + yyyy + " " + hh; 
}

function tgl_id_long(param){
    if(param===null || param===""){
        return "";
    }
    var yyyy = param.substring(0, 4);
    var mm = param.substring(5, 7);
    var dd = param.substring(8, 10);
    var hh = param.substring(10, 20);
    return dd + " " + bulan[Number(mm)] + " " + yyyy + " " + hh; 
}

function money_id(param){
    if(param < 0){
        return "(" + numeral(Math.abs(param.toString())).format('0,0') + ")";
    }else{
        return numeral(param).format('0,0');
    }
}