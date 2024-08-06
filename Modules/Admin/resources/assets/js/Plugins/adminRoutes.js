const AdminRouter = {"url":"http:\/\/core.test","port":null,"defaults":{},"routes":{"adminWeb.index":{"uri":"admin","methods":["GET","HEAD"]},"adminWeb.logout":{"uri":"admin\/logout","methods":["POST"]},"adminWeb.login":{"uri":"admin\/login","methods":["GET","HEAD"]},"adminWeb.login-post":{"uri":"admin\/login","methods":["POST"]}}};
if (typeof window !== 'undefined' && typeof window.AdminRouter !== 'undefined') {
  Object.assign(AdminRouter.routes, window.AdminRouter.routes);
}
export { AdminRouter };