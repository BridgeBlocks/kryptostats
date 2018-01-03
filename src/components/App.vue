<template>
  <div id="app" class="container">
    <autocomplete :suggestions="suggestions" v-model="selection"></autocomplete>
  </div>
</template>

<script>
import Autocomplete from './Autocomplete';

var item, key, names = [];

for( key in coins.Data ) {
  if( !coins.Data.hasOwnProperty(key) ) continue;
  item = coins.Data[key];
  names.push(
    {
      coinName: item.CoinName.toLowerCase(),
      coinId: item.Id,
      coinTicker: item.Symbol,
    });
}

export default {
  name: 'app',
  components: {
    Autocomplete
  },
  data () {
    return {
      selection: '',
      suggestions: names,
      coins: coins,
    }
  },
  /*methods: {
    getCoins: function() {
      return coins.Data;
   }
 }*/
}

</script>
