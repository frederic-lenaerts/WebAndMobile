import React, { Component } from 'react'
import Menu from './menu'
import Pages from './pages'
import { BrowserRouter } from 'react-router-dom';

class View extends Component {
    render() {
        return (
            <BrowserRouter>
                <div style={{ fontFamily: '"Roboto", "Helvetica", "Arial", sans-serif',
                              fontSize: 15 }}
                >
                    <Menu />
                    <Pages />
                </div>
            </BrowserRouter>
        );
    }
}

export default View;
