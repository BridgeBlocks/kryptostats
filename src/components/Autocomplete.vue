<template>
    <div class="cryptostats__exhange-search-widget" style="position:relative" v-bind:class="{'open':openSuggestion}">
        <label for="coin-peiler velger">Coin-peiler(små bokstaver)
          <input name="coin-peiler velger" placeolder="bitcoin" class="form-control" type="text" :value="value" @input.prevent="updateValue($event.target.value)"
            @keydown.enter = 'enter'
            @keydown.down = 'down'
            @keydown.up = 'up'
          >
        </label>
        <ul class="cryptostats__coin-dropdown-menu" style="width:100%">
            <li v-for="(suggestion, index) in matches"
                v-bind:class="{'active': isActive(index)}"
                @click.prevent="suggestionClick(index)"
            >
              <a href="#">{{ suggestion.coinName }} <small>{{ suggestion.coinTicker }}</small>
              </a>
            </li>
        </ul>
        <p class="cryptostats__exchange-results" v-for="exchange in coinExchanges">
          <span v-html="exchange"></span>
        </p>

    </div>

</template>

<script>

import axios from 'axios'

export default {
  props: {
    value: {
      type: String,
      required: true
    },
    suggestions: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
      open: false,
      current: 0,
      coinExchanges: [],
      errors: []
    }
  },

  computed: {
    // Filtering the suggestion based on the input
    matches () {
      return this.suggestions.filter((obj) => {
        return obj.coinName.indexOf(this.value) >= 0
      })
    },
    openSuggestion () {
      return this.selection !== '' &&
             this.matches.length !== 0 &&
             this.open === true
    }
  },
  methods: {
    updateValue (value) {
      if (this.open === false) {
        this.open = true
        this.current = 0
      }
      this.$emit('input', value)
    },
    // When enter pressed on the input
    enter () {
      this.$emit('input', this.matches[this.current].coinName)
      this.open = false
    },
    // When up pressed while suggestions are open
    up () {
      if (this.current > 0) {
        this.current--
      }
    },
    // When up pressed while suggestions are open
    down () {
      if (this.current < this.matches.length - 1) {
        this.current++
      }
    },
    // For highlighting element
    isActive (index) {
      return index === this.current
    },
    // When one of the suggestion is clicked
    suggestionClick (index) {
      this.$emit('input', this.matches[index].coinName)
      this.open = false

      axios.post(baseurl + '/assets/request.php', {
        body: this.matches[index].coinId
      })
      .then(response => {
        this.coinExchanges = response.data;

      })
      .catch(e => {
        this.errors.push(e)
      })
    }
  }
}
</script>

<style>
.cryptostats__exhange-search-widget .cryptostats__coin-dropdown-menu {
  display: none;
}

.cryptostats__exhange-search-widget.open .cryptostats__coin-dropdown-menu {
  display: block;
}

.cryptostats__exhange-search-widget ul li, .cryptostats__exchanges-list-item {
  list-style: none;
}
</style>
