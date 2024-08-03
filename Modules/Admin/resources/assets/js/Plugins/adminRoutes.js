const AdminRoute = {"url":"http:\/\/core.test","port":null,"defaults":{},"routes":{"adminWeb.index":{"uri":"admin","methods":["GET","HEAD"]},"adminWeb.login":{"uri":"admin\/login","methods":["GET","HEAD"]},"adminWeb.login-post":{"uri":"admin\/login","methods":["POST"]}}};
if (typeof window !== 'undefined' && typeof window.AdminRoute !== 'undefined') {
  Object.assign(AdminRoute.routes, window.AdminRoute.routes);
}
export  { AdminRoute };