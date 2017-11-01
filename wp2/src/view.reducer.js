const initialState = {
    title: 'Dashboard',
    statusEntries: [],
    locationEntries: [],
    reportEntries: [],
}

const viewreducer = ( state = initialState, action ) => {
    switch ( action.type ) {
        case 'SET_TITLE':
            return { ...state, ...{ title: action.payload } }
        case 'SET_STATUSENTRIES':
            return { ...state, ...{ statusEntries: action.payload }}
        case 'ADD_STATUSENTRY':
            return { ...state, ...{ statusEntries: [...state.statusEntries, action.payload]}}
        case 'SET_LOCATIONENTRIES':
            return { ...state, ...{ locationEntries: action.payload }}
        case 'SET_REPORTENTRIES':
            return { ...state, ...{ reportEntries: action.payload }}
        default:
            return state
    }
}

export default viewreducer