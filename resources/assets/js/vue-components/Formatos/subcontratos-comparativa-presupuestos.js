Vue.component('subcontratos-comparativa-presupuestos',{
    data : function () {
        return {

        }
    },

    mounted : function () {
        $('#remote .typeahead').typeahead(null, {
            name: 'best-pictures',
            display: 'value',
            source: new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: 'http://localhost:8000/testing?q=%QUERY',
                    wildcard: '%QUERY'
                }
            })
        });
    }
});