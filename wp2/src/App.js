import React, { Component } from 'react';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import View from './common/view';
import { Provider } from 'react-redux';
import store from './common/store';

class App extends Component {
  render() {
    return (
      <Provider store={ store }>
        <MuiThemeProvider>
          <View />
        </MuiThemeProvider>
      </Provider>
    );
  }
}

export default App;
