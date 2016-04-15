# -*- coding: utf-8 -*-
require 'pp'
require_relative 'lexer'
require_relative 'ast'


JAVA_TOKEN_DEF={

	#Conditions
	:if		=> /if/,
	:else		=> /else/,
	:do	        => /do/,
	:while		=> /while/,
	:for		=> /for/,

	#Primitive types
	:int		=> /int/,
	:bool		=> /boolean/,
	:void		=> /void/,

	#Boolean
	:true		=> /true/,
	:false		=> /false/,

	#Misc
	:void		=> /void/,
	:class		=> /class/,
	:public		=> /public/,
	:private	=> /private/,
	:extends	=> /extends/,
	:static		=> /static/,
	:main		=> /main/,
	:string		=> /String/,
	:return		=> /return/,
	:this		=> /this/,

	#Punctuation
	:semicolon	=> /\;/,
	:dot		=> /\./,
	:colon		=> /:/,
	:comma		=> /\,/,
	:lbracket	=> /\(/,
	:rbracket	=> /\)/,
	:lsbracket	=> /\[/,
	:rsbracket	=> /\]/,
	:lsbrace	=> /\{/,
	:rsbrace	=> /\}/,

	#Operators
	:infeq		=> /<=/,
	:supeq		=> />=/,
	:sup		=> />/,
	:inf		=> /</,
	:not		=> /!/,
	:differ		=> /!=/,
	:eq		=> /\=/,
	:multiply	=> /\*/,
	:substract	=> /\-/,
	:plus		=> /\+/,
	:div		=> /\//,
	:or		=> /\|\|/,
	:and		=> /\&\&/,

	:ident	  	=> /[a-zA-Z][a-zA-Z0-9_]*/,
	:integer	=> /[0-9]+/,
	
}

class Parser

	attr_accessor :lexer

	def initialize verbose=false
		@lexer=Lexer.new(JAVA_TOKEN_DEF)
		@verbose=verbose
	end

	def parse filename
		str=IO.read(filename)
		@lexer.tokenize(str)
		parseProg()
	end

	def expect token_kind
		next_tok=@lexer.get_next
		if next_tok.kind!=token_kind
			puts "expecting #{token_kind}. Got #{next_tok.kind}"
			raise "parsing error on line #{next_tok.pos.first}"
		end   
		return next_tok
	end
  
	def showNext
		@lexer.show_next
	end

	def acceptIt
		@lexer.get_next
	end

	def say txt
		puts txt if @verbose
	end

	def eof?
		@lexer.eof?
	end
	
	def lookahead k
		@lexer.lookahead(k)
	end

#=========== parse method relative to the grammar ========

	#Done
	def parseProg
		puts "parseProg"

		prog = Program.new
		prog.mainClass = parseMainClass()
		classNode = ClassSequence.new
		while !eof?() #stops when file ends
			classNode.list << parseClassDeclaration()
		end
		prog.classList = classNode

		return prog
	end

	#Done
	def parseMainClass
		puts "parseMainClass"

		expect :class
		mainClass = MainClass.new
		mainClass.name = parseIdentifier()
		expect :lsbrace
		expect :public
		expect :static
		expect :void
		expect :main
		expect :lbracket
		expect :string
		expect :lsbracket
		expect :rsbracket
		mainClass.args = parseIdentifier()
		expect :rbracket
		expect :lsbrace
		mainClass.statementList = parseStatementSequence()
		expect :rsbrace
		expect :rsbrace

		return mainClass
	end

	def parseClassDeclaration
		puts "parseClassDeclaration"

		expect :class
		classe = Klass.new
		classe.name = parseIdentifier()
		if showNext.kind == :extends
			acceptIt
			classe.legacy = parseIdentifier()
		end
		expect :lsbrace
		varList = VarSequence.new
		methList = MethSequence.new
		tmp = Variable.new

		while showNext.kind != :rsbrace
			tmp.modifier = parseModifier()
			tmp.type = parseType()
			tmp.name = parseIdentifier()

			if showNext.kind == :semicolon
				varList.list << parseVarDeclarationBis(tmp)
			elsif showNext.kind == :lbracket
				methList.list << parseMethodDeclaration(tmp)
			else
				puts "error"
			end
		end
		expect :rsbrace
		classe.varList = varList
		classe.methList = methList

		return classe
	end

	def parseVarDeclaration
		puts "parseVarDeclaration"

		var = Variable.new
		var.modifier = parseModifier()
		var.type = parseType()
		puts var.type.kind
		var.name = parseIdentifier()
		puts var.name

		return var
	end
	
	def parseVarDeclarationBis tmp
		puts "parseVarDeclarationBis"

		var = Variable.new
		var.modifier = tmp.modifier
		var.type = tmp.type
		var.name = tmp.name
		expect :semicolon

		return var
	end

	def parseMethodDeclaration tmp
		puts "parseMethodDeclaration"

		method = MethodDecl.new
		method.modifier = tmp.modifier
		method.type = tmp.type
		method.name = tmp.name
		nodeVar = VarSequence.new
		expect :lbracket
		if showNext.kind != :rbracket
			nodeVar.list << parseVarDeclaration()
			while showNext.kind == :comma
				acceptIt
				nodeVar.list << parseVarDeclaration()
			end
		end
		expect :rbracket
		method.varList = nodeVar
		expect :lsbrace
		method.stmtList = parseStatementSequence()
		if (showNext.kind == :return) and (method.type != :void)
			acceptIt
			method.output << parseExpression()
			expect :semicolon
		elsif (showNext.kind == :return) and (method.type == :void)
			puts "no return in void-type functions !"
		end
		expect :rsbrace
		
		return method
	end

	def parseModifier
		puts "parseModifier"
		
		modifier = Modifier.new
		if (showNext.kind == :public) or (showNext.kind == :private)
			modifier.kind = acceptIt
		else
			modifier.kind = nil
		end

		return modifier
	end

	def parseType
		puts "parseType"
		
		type = TypeDecl.new
		if (showNext.kind == :int) or (showNext.kind == :void) or (showNext.kind == :bool)
			type.kind = acceptIt
		else
			type.kind = parseIdentifier()
		end
		if showNext.kind == :lsbracket
			acceptIt
			expect :rsbracket
		end

		return type
	end

#------------------------ Statements -----------------------#

	def parseStatement
		puts "parseStatement"

		statement = Statement.new
		if showNext.kind != :rsbrace
			case showNext.kind
				when :if then
					statement=parseIfStmt()
				when :while then
					statement=parseWhileStmt()
				when :for then
					statement=parseForStmt()
				when :lsbrace then
					acceptIt
					statement = parseStatementSequence()
					expect :rsbrace
				when :int, :bool, :void then
					statement = parseLocalVarDecl()
				else
					statement = parseExpression()
					expect :semicolon
			end
		end

		return statement
	end

	def parseIfStmt
		puts "parseIfStmt"

		ifStmt = IfStatement.new
		expect :if
		expect :lbracket
		ifStmt.cond = parseExpression()
		expect :rbracket
		ifStmt.ifStmtBlock = parseStatement()
		if showNext.kind == :else
			acceptIt
			ifStmt.elseStmtBlock = parseStatement()
		end

		return ifStmt
	end

	def parseWhileStmt
		puts "parseWhileStmt"

		whileStmt = WhileStatement.new
		expect :while
		expect :lbracket
		whileStmt.cond = parseExpression()
		expect :rbracket
		whileStmt.stmtBlock = parseStatement()

		return whileStmt
	end

	def parseForStmt
		puts "parseForStmt"
		
		forStmt = ForStatement.new
		expect :for
		expect :lbracket
		forStmt.beginCond = parseLocalVarDecl()
		forStmt.endCond = parseExpression()
		expect :semicolon
		forStmt.assignment = parseExpression() #/!\ not conform to grammar
		expect :rbracket
		forStmt.stmtBlock = parseStatement()

		return forStmt
	end

	def parseStatementSequence()
		puts "parseStatementSequence"

		statement = StatementSequence.new
		while showNext.kind != :rsbrace
			statement.list << parseStatement()
		end

		return statement
	end

#------------------------ End statements -----------------------#

	#Checked
	def parseLocalVarDecl
		puts "parseLocalVarDecl"

		localVar = LocalVariable.new
		localVar.type = parseType()
		localVar.name = parseIdentifier()
		expect :eq
		localVar.expr = parseExpression()
		expect :semicolon

		return localVar
	end

	#TODO
	def parseExpression
		puts "parseExpression"

		expr = Expression.new
		if showNext.kind == :this
			expr.ref = parseReference()
		elsif showNext.kind == :new
			acceptIt
			expr.ident = parseIdentifier()
			if showNext.kind == :lbracket
				acceptIt
				expect :rbracket
			elsif showNext.kind == :lsbracket
				acceptIt
				expr.expr = parseExpression()
				expect :rsbracket
			else
				puts "error in parsing Expression"
			end
		elsif showNext.kind == :lbracket
			acceptIt
			expr.expr = parseExpression()
			expect :rbracket
		elsif (showNext.kind == :integer) or (showNext.kind == :true) or (showNext.kind == :false)
			expr.lit = parseLiteral()
		elsif showNext.kind == :not
			expr.op = acceptIt
			expr.expr = parseExpression()
		else
			expr.ref = parseReference()
			if showNext.kind == :eq
				acceptIt
				expr.expr = parseExpression()
			end
		end

		return expr
	end

	#TODO A tester sans le "this."
	def parseReference
		puts "parseReference"

		reference = Reference.new
		if showNext.kind == :this
			acceptIt
			expect :dot
		end
		reference.targetList << parseTarget()
		while showNext.kind == :dot
			acceptIt
			reference.targetList << parseTarget()
		end

		return reference
	end

	#Checked
	def parseTarget
		puts "parseTarget"

		target = Target.new
		target.ident = parseIdentifier()
		nodeExpr = ExpressionSequence.new
		if showNext.kind == :lsbracket
			acceptIt
			nodeExpr.list << parseExpression()
			expect :rsbracket
		elsif showNext.kind == :lbracket
			acceptIt
			if showNext.kind != :rbracket
				nodeExpr.list << parseExpression()
				while showNext.kind == :comma
					nodeExpr.list << parseExpression()
				end
			end
			expect :rbracket
		end
		target.exprList = nodeExpr

		return target
	end

	#TODO pas de reconnaissance de String
	def parseLiteral
		puts "parseLiteral"
		
		literal = Literal.new
		if (showNext.kind == :integer) or (showNext.kind == :true) or (showNext.kind == :false)
			literal.lit = acceptIt
		else
			literal.lit = nil
		end
		
		return literal
	end

	#Checked
	def parseIdentifier
		puts "parseIdentifier"

		ident = Identifier.new
		ident.name = expect(:ident)

		return ident
	end
end
