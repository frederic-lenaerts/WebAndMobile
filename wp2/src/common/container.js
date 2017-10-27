import React, { Component } from 'react'
import View from './view'
import Routes from './routes'
import { BrowserRouter } from 'react-router-dom';

class Container extends Component {
    render() {
        return (
            <BrowserRouter>
                <div>
                    <View />
                    <Routes />
                </div>
            </BrowserRouter>
        );
    }
}

export default Container;
