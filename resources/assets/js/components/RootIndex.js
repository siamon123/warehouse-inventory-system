import React, {Component} from 'react';
import ReactDOM from 'react-dom';

export default class RootIndex extends Component {
  render() {
    return (
      <div className="container">
        <div className="row justify-content-center">
          <div className="col-md-8">
            <div className="card">
              <div className="card-header">Root Index Component</div>

              <div className="card-body">
                This is the root index
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

if (document.getElementById('root-index')) {
  ReactDOM.render(<RootIndex />, document.getElementById('root-index'));
}
