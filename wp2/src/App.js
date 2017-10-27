import React, { Component } from 'react';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import Container from './common/container';
import { Provider } from 'react-redux';
import store from './common/store';

class App extends Component {
  render() {
    return (
      <Provider store={ store }>
        <MuiThemeProvider>
          <Container />
        </MuiThemeProvider>
      </Provider>
    );
  }
}

export default App;
