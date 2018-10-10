jQuery(document).ready(function() {
  
function convertToSlug(Text)
{
  return Text
      .toLowerCase()
      .replace(/ /g,'-')
      .replace(/[^\w-]+/g,'')
      ;
}



jQuery(document).ready(function() {
  var t = jQuery('#coin-all-list').DataTable( {
      "ajax": "http://localhost/token/wp-content/uploads/coinlist.json",
      "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
      "pageLength": 100,
      "columnDefs": [
        { className: "cr-coinname thumb", "targets": [ 1 ] }
      ],
      "order": [[ 4, "desc" ]],
      "columns": [
          { "data": "id" },
          { "data": "Name",
            render : function(data, type, row) {
            return '<a href="' + convertToSlug(row.CoinName+ ' ('+row.Name+')') + '"><img src="https://www.cryptocompare.com'+row.ImageUrl+'"><div class="cr-coin-fullname">'+row.Name+'</div><div class="cr-coin-name">'+row.CoinName+'</div></a>'
        }  },
          { "data": "CHANGEPCT24HOUR",
          render : function(data, type, row) {
            let n_p_class = 'red';
            if ((row.CHANGEPCT24HOUR * 1) >= 0) {
                n_p_class = 'green';
            }
            return '<span class="'+n_p_class+'">'+row.CHANGEPCT24HOUR+'</span>';

          }},
          { "data": "PRICE",
          render : function(data, type, row) {

            return '<span class="cr-price">'+row.PRICE+'</span>';

          } },
          { "data": "VOLUME24HOURTO" },
          { "data": "MKTCAP" },
          { "data": "SUPPLY" }
      ]
  } );



  t.on( 'order.dt search.dt', function () {
    t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
    } );
} ).draw();

} );



