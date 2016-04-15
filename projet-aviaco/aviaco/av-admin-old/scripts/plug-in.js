/**
 * When search a table with accented characters, it can be frustrating to have
 * an input such as _Zurich_ not match _ZÃ¼rich_ in the table (`u !== Ã¼`). This
 * type based search plug-in replaces the built-in string formatter in
 * DataTables with a function that will remove replace the accented characters
 * with their unaccented counterparts for fast and easy filtering.
 *
 * Note that with the accented characters being replaced, a search input using
 * accented characters will no longer match. The second example below shows
 * how the function can be used to remove accents from the search input as well,
 * to mitigate this problem.
 *
 *  @summary Replace accented characters with unaccented counterparts
 *  @name Accent neutralise
 *  @author Allan Jardine
 *
 *  @example
 *    $(document).ready(function() {
 *        $('#example').dataTable();
 *    } );
 *
 *  @example
 *    $(document).ready(function() {
 *        var table = $('#example').dataTable();
 *
 *        // Remove accented character from search input as well
 *        $('#myInput').keyup( function () {
 *          table
 *            .search(
 *              jQuery.fn.DataTable.ext.type.search.string( this )
 *            )
 *            .draw()
 *        } );
 *    } );
 */

jQuery.fn.DataTable.ext.type.search.string = function ( data ) {
    return ! data ?
        '' :
        typeof data === 'string' ?
            data
                .replace( /Î­/g, 'Îµ')
                .replace( /Ï/g, 'Ï…')
                .replace( /ÏŒ/g, 'Î¿')
                .replace( /ÏŽ/g, 'Ï‰')
                .replace( /Î¬/g, 'Î±')
                .replace( /Î¯/g, 'Î¹')
                .replace( /Î®/g, 'Î·')
                .replace( /\n/g, ' ' )
                .replace( /Ã¡/g, 'a' )
                .replace( /Ã©/g, 'e' )
                .replace( /Ã­/g, 'i' )
                .replace( /Ã³/g, 'o' )
                .replace( /Ãº/g, 'u' )
                .replace( /Ãª/g, 'e' )
                .replace( /Ã®/g, 'i' )
                .replace( /Ã´/g, 'o' )
                .replace( /Ã¨/g, 'e' )
                .replace( /Ã¯/g, 'i' )
                .replace( /Ã¼/g, 'u' )
                .replace( /Ã£/g, 'a' )
                .replace( /Ãµ/g, 'o' )
                .replace( /Ã§/g, 'c' )
                .replace( /Ã¬/g, 'i' ) :
            data;
};