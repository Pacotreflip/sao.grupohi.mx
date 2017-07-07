Vue.component('select2', {
    props: ['options', 'value','name'],
    template: '<select><slot></slot></select>',
    mounted: function () {
        var vm = this
        var data = [];

        $.each(this.options, function (id, text) {
            data.push({id: id, text: text})
        })

        function SortByName(a, b){
            var aName = a.text.toLowerCase();
            var bName = b.text.toLowerCase();
            return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
        }

        data = data.sort(SortByName);
        $(this.$el).attr('name',this.name)
        $(this.$el).select2({
                data: data,
                width: '100%'
        })
            .val(this.value)
            .trigger('change')
            // emit event on change.
            .on('change', function () {
                vm.$emit('input', this.value)
            })
    },
    watch: {
        value: function (value) {
            // update value
            $(this.$el).val(value).trigger('change');
        },
        options: function (options) {
            // update options
            $(this.$el).select2({
                data: options,
                width: '100%'
            })
        }
    },
    destroyed: function () {
        $(this.$el).off().select2('destroy')
    }
});