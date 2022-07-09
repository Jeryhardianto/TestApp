   //convert a string like "1.234.567,89" to a float like 1234567.89
   function strToFloat(str) {
       str += ''; //force it to be a string
       if (str == '') {
           return 0.0;
       }
       return parseFloat(str.replace(/\./g, "").replace(",", "."));
   }

   //convert a string like "1.234.567,89" to an integer like 1234567
   function strToInt(str) {
       str += ''; //force it to be a string
       if (str == '') {
           return 0;
       }
       return parseInt(str.replace(/\./g, "").replace(",", "."));
   }

   //convert a number like 1234567.89 to a string like "1.234.567,89"
   function numberToStr(num) {
       var parts = num.toString().split(".");
       parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
       return parts.join(",");
   }

   $('#nominal').keyup(
       function() {
           nominal = strToFloat($('#nominal').val().replace(/[^0-9]/g, ''));
           $('#nominal').val(numberToStr(nominal));
           $('#nominalx').val(nominal);
       }
   );

   $(document).ready(function() {
       var subk = $("#katx").val();
       $('#kategori').val(subk);

       var jenistransx = $("#jenistransx").val();
       $('#jenistrans').val(jenistransx);

       nominal = strToFloat($('#nominal').val().replace(/[^0-9]/g, ''));
       $('#nominal').val(numberToStr(nominal));
       $('#nominalx').val(nominal);


   })