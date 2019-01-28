import {Common, Layout} from './../Components';
import DeleteAction from './../com/Actions/Delete';
import CTable from './../com/Table';
import Payload from './Payload';

Vue.component('DeleteAction', DeleteAction);
Vue.component('Payload', Payload);

export default _.assignIn(
    Common,
    Layout,
    {
        CTable,
        DeleteAction
    }
)
