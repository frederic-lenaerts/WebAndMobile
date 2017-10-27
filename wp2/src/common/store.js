import { createStore } from 'redux';
import ViewReducer from '../view.reducer';

const store = createStore( ViewReducer, window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__() );

export default store;
