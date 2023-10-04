const { default: axios } = require('axios')

/**
 *
 * Custom functions JS
 *
 */
export default {

    methods: {
        /**
         *
         * @param {*} date
         * @param {*} format
         * @returns
         */
        formatDate( date, format = "DD.MM.YYYY" ) {
            return moment( date ).format( format )
        },
        /**
         * Validation input
         *
         * @param {*} dataField text Input
         * @returns
         */
        validateField(field, custom_text) {
            if ( field === "" || field === undefined ||  field === null ) {
                return custom_text ? custom_text : "Required"
            } else {
                return ""
            }
        },

      }
  }

