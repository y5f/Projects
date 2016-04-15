class Ast
	def accept(visitor, arg=nil)
		name = self.class.name.split(/::/)[0]
		visitor.send("visit#{name}".to_sym, self ,arg)
	end
end

class Program < Ast
	attr_accessor :mainClass, :classList
	def initialize mainClass=nil,classList=[]
		@mainClass,@classList=mainClass,classList
	end
end

class MainClass < Ast
	attr_accessor :name, :args, :statementList
	def initialize name=nil,args=nil,statements=[]
		@name,@args,@statements=name,args,statements
	end
end

class Identifier < Ast
	attr_accessor :name
	def initialize name=nil
		@name=name
	end

	def to_s
		@name.value
	end
end

class Klass < Ast
	attr_accessor :name, :legacy, :varList, :methList
	def initialize name=nil,legacy=nil,varList=[],methList=[]
		@name,@legacy,@varList,@methList=name,legacy,varList,methList
	end
end

class ClassSequence < Ast
	attr_accessor :list
	def initialize list=[]
		@list = list
	end

	def each &block
		list.each(&block)
	end
end

class VarSequence < Ast
	attr_accessor :list
	def initialize list=[]
		@list = list
	end

	def each &block
		list.each(&block)
	end
end

class MethSequence < Ast
	attr_accessor :list
	def initialize list=[]
		@list = list
	end

	def each &block
		list.each(&block)
	end
end

#------------------------ Statements -----------------------#

class Statement < Ast
end

class IfStatement < Statement
	attr_accessor :cond, :ifStmtBlock, :elseStmtBlock
	def initialize cond=nil,ifStmtBlock=[],elseStmtBlock=[]
		@cond,@ifStmtBlock,@elseStmtBlock=cond,ifStmtBlock,elseStmtBlock
	end
end

class WhileStatement < Statement
	attr_accessor :cond, :stmtBlock
	def initialize cond=nil,stmtBlock=[]
		@cond,@stmtBlock=cond,stmtBlock
	end
end

class ForStatement < Statement
	attr_accessor :beginCond, :endCond, :assignment, :stmtBlock
	def initialize beginCond=nil,endCond=nil,assignment=nil,stmtBlock=[]
		@beginCond,@endCond,@assignment,@stmtBlock=beginCond,endCond,assignment,stmtBlock
	end
end

class StatementSequence < Statement
	attr_accessor :list
	def initialize list=[]
		@list = list
	end

	def each &block
		list.each(&block)
	end
end

#----------------------- End statements ----------------------#

class MethodDecl < Ast
	attr_accessor :modifier, :type, :name, :varList, :stmtList, :output
	def initialize modifier=nil,type=nil,name=nil,varList=[],stmtList=[],output=nil
		@modifier,@type,@name,@varList,@stmtList,@output = modifier,type,name,varList,stmtList,output
	end
end

class Variable < Ast
	attr_accessor :modifier, :type, :name
	def initialize modifier=nil,type=nil,name=nil
		@modifier,@type,@name = modifier,type,name
	end
end

class LocalVariable < Ast
	attr_accessor :type, :name, :expr
	def initialize type=nil,name=nil,expr=nil
		@type,@name,@expr = type,name,expr
	end
end

class TypeDecl < Ast
	attr_accessor :kind
	def initialize kind=nil
		@kind = kind
	end
end

class Modifier < Ast
	attr_accessor :kind
	def initialize kind=nil
		@kind = kind
	end
end

class Target < Ast
	attr_accessor :ident, :exprList
	def initialize ident=nil, exprList=[]
		@ident,@exprList = ident,exprList
	end
end

class TargetSequence < Ast
	attr_accessor :list
	def initialize list=[]
		@list = list
	end

	def each &block
		list.each(&block)
	end
end

class Expression < Ast
	attr_accessor :ref, :lit, :ident, :expr, :op
	def initialize ref=nil,lit=nil,ident=nil,expr=nil,op=nil
		@ref,@lit,@ident,@expr,@op=ref,lit,ident,expr,op
	end
end

class ExpressionSequence < Ast
	attr_accessor :list
	def initialize list=[]
		@list = list
	end

	def each &block
		list.each(&block)
	end
end

class Reference < Ast
	attr_accessor :targetList
	def initialize targetList=[]
		@targetList = targetList
	end
end

class Literal < Ast
	attr_accessor :lit
	def initialize lit=nil
		@lit = lit
	end
end
