# 运行说明:  

安装swoole扩展（4.0版本以上）后，
在Client 下运行  
`php bin/Simple http:start`    

在Server1、Server2 下运行  
`php bin/Simple rpc:start`

浏览器中访问http://127.0.0.1:9600/admin/index 查看结果

# 目录说明：  

client—客户端  
server1 — 模拟服务端  
server2 — 模拟服务端  

**Application 应用程序目录**    
　　|— Admin  
　　|— Api 模拟控制器  
　　|— Bean.php IOC容器配置  
**bin**    
　　|— SimpleRpc **服务启动程序**    
**config 配置文件目录（此目录下的配置运行时都会自动加载）**      
　　|— default.php 默认配置  
　　|— services.php RPC服务器配置  
**framework**    
　　|— SimpleRpc  
　　　　|— Core **框架核心目录**  
　　　　　　|— Annotation 注解  
　　　　　　　　|— Parse.php 注解收集解析  
　　　　　　|— Bean  
　　　　　　　　|— BeanFactory.php IOC静态工厂  
　　　　　　|— Http  
　　　　　　　　|— Server.php http服务  
　　　　　　|— Route  
　　　　　　　　|— Annotation 路由注解  
　　　　　　　　|— Mapping  
　　　　　　　　　　|— Controller.php 类路由注解  
　　　　　　　　　　|— RequestMapping.php 方法注解组合  
　　　　　　　　|— Parser  
　　　　　　　　　　|— RequestMappingParser 路由注解信息组合添加  
　　　　　　　　|— Route.php 路由注解类 增加，分发  
　　　　　　|— Rpc  
　　　　　　　　|— Client.php Rpc客户端  
　　　　　　　　|— Server.php Rpc服务端  
　　　　　　|— Config.php 配置信息类  
　　　　　　|— Reload.php 热加载类  
　　　　　　|— Server.php 服务类基类  
　　　　|— App.php 框架入口程序  
