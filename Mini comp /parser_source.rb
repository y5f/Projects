# -*- coding: utf-8 -*-
require 'pp'
require_relative 'lexer'
require_relative 'ast'


OBERON_TOKEN_DEF={

	#
	:class		=> /class/,

	#Conditions
	:if		=> /if/,
	:else		=> /else/,
	:do	        => /do/,
	:while		=> /while/,

	#Primitive types
	:int		=> /int/,
	:bool		=> /boolean/,
	:void		=> /void/,
	
	#manque boolean et void

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
	:eq		=> /\=/, #a enlever ??
	:multiply	=> /\*/,
	:substract	=> /\-/,
	:plus		=> /\+/,
	:div		=> /\//,
	:or		=> /\|\|/,
	:and		=> /\&\&/,

	:ident	  	=> /[a-zA-Z][a-zA-Z0-9_]*/,
	:integer	=> /[0-9]+/,

	#Added
	:public		=> /public/,
	:private	=> /private/,
	:extends	=> /extends/,
	:static		=> /static/,
	:main		=> /main/,
	:string		=> /String/,
}

class Parser

	attr_accessor :lexer

	def initialize verbose=false
		@lexer=Lexer.new(OBERON_TOKEN_DEF)
		@verbose=verbose
	end

	def parse filename
		str=IO.read(filename)
		@lexer.tokenize(str)
		parseModule()
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

#=========== parse method relative to the grammar ========

	#Checked
	def parseProg
		puts "parseProg"

		parseMainClass()
		while showNext.kind != :rsbrace
			parseClassDeclaration()
		end
		expect :rsbrace

		return nil
	end

	#Checked
	def parseMainClass # attr_accessor :ident1 :ident2 :statements
		puts "parseMainClass"

		expect :class
		mainClass = MainClass.new
		mainClass.ident1 = parseIdentifier()
		expect :lsbrace
		expect :public
		expect :static
		expect :void
		expect :main
		expect :lbracket
		expect :string
		expect :lsbracket
		expect :rsbracket
		mainClass.ident2 = parseIdentifier()
		expect :rbracket
		expect :lsbrace
		mainClass.statements = parseStatement()
		expect :rsbrace

		return mainClass
	end

	#Ongoing
	def parseClassDeclaration #
		puts "parseClassDeclaration"

		expect :class
		classe = Class.new
		classe.ident1 = parseIdentifier()
		if showNext.kind == :extends
			acceptIt
			parseIdentifier() #add to attributes
		end
		expect :lsbrace
		while showNext.kind != :rsbrace
			#trouver comment distinguer une variable dune methode
		end
		expect :rsbrace

		return classe
	end

	#Done
	def parseVarDeclaration # attr_accessor :modifier :type :ident
		say "parseVarDeclaration"

		var = Variable.new
		var.modifier = parseModifier()
		var.type = parseType()
		var.ident = parseIdent()
		expect :semicolon

		return var
	end

	#Ongoing
	def parseMethodDeclaration
		say "parseMethodDeclaration"

		method = Method.new
		method.modifier = parseModifier()
		method.type = parseType()
		method.ident = parseIdent()
		expect :lbracket
		if showNext.kind != :rbracket
			parseType()#add to attributes
			parseIdentifier()#add to attributes
			while showNext.kind == :comma
				acceptIt
				parseType()#add to attributes
				parseIdentifier()#add to attributes
			end
		end
		expect :rbracket
		expect :lsbrace
		while showNext.kind != :rsbrace
			parseStatement()#add to attributes
		end
		if showNext.kind == :return
			acceptIt
			parseExpression()#add to attributes
			expect :semicolon
		end
		expect :rsbrace
			
		return method
	end

	#Ongoing
	def parseModifier # attr_accessor 
		say "parseModifier"
		modifier = Modifier.new

		modif.

		return modif
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

	def parseStatement
		puts "parseStatement"

		statements = StatementSequence.new
		case showNext.kind 
			when :if then
				acceptIt
				expect :lbracket
				parseExpression() #add to attributes
				expect :rbracket
				parseStatement() #add to attributes
				if showNext.kind == :else
					acceptIt
					parseStatement() #add to attributes
				end
			when :while then
				acceptIt
				expect :lbracket
				parseExpression() #add to attributes
				expect :rbracket
				parseStatement()
			when :for then
				acceptIt
				expect :lbracket
				parseLocalVarDecl() #add to attributes
				expect :semicolon
				parseExpression() #add to attributes
				expect :semicolon
				parseExpression() #add to attributes /!\ not conform to grammar
				expect :rbracket
				parseStatement() #add to attributes
			when :lsbrace then
				acceptIt
				while showNext.kind != :rsbrace
					parseStatement() #add to attributes
				end
				expect :rsbrace
			when (:public or :private) then
				parseLocalVarDecl() #add to attributes
			else
				parseExpression() #add to attributes
				expect :semicolon
		end

		return statements
	end

	def parseLocalVarDecl
		puts "parseLocalVarDecl"

		localVar = LocalVariable.new
		localVar.type = parseType()
		localVar.ident = parseIdentifier()
		expect :eq
		localVar.expr = parseExpression()

		return localVar
	end

def parseExpression
	puts "parseExpression"

	return expression
end

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

	def parseTarget
		puts "parseTarget"

		target = Target.new
		target.ident = parseIdentifier()
		nodeExpr = ExpressionSequence.new
		if showNext.kind == :lsbracket
			nodeExpr.list << parseExpression()
		elsif showNext.kind == :lbracket
			nodeExpr.list << parseExpression()
			while showNext.kind == :comma
				nodeExpr.list << parseExpression()
			end
		else
			nodeExpr.list << nil
		end
		target.exprList = nodeExpr

		return target
	end

def parseLiteral
	puts "parseLiteral"

	return literal
end

	#Done
	def parseIdentifier
		say "parseIdentifier"

		ident = Identifier.new
		ident.name = expect :ident

		return ident
	end

#-------------------------------------------------

 def parseModule
   say "parseModule"
   expect :module
   modul= Modul.new
   modul.ident1 = Identifier.new(expect(:ident))
   expect :semicolon
   modul.declarations= parseDeclarations()
   if showNext.kind==:begin
     acceptIt
     modul.statements=parseStatementSequence()
   end
   expect :end 
   modul.ident2 = Identifier.new(expect(:ident))
   expect :dot
   return modul
  end
    
  def parseStatementSequence
    node = StatementSequence.new
    say "parseStatementSequence"
    node.list << parseStatement()
    while showNext.kind==:semicolon
      acceptIt
      node.list << parseStatement()
    end
    return node
  end

  def parseExpression
    say "parseExpression"
    node=Expression.new
    node.lhs=parseSimpleExpression()
    operators=[:eq,:hashtag,:inf,:infeq,:sup,:supeq]
    if operators.include? showNext.kind
      node.operator=Operator.new(acceptIt)
      node.rhs=parseSimpleExpression()
    end
    return node
  end

  def parseFactor
    say "parseFactor"
     
    case showNext.kind 
    when :ident then
      factor=IdentSelector.new
      factor.ident=Identifier.new(acceptIt)
      factor.selector=parseSelector()
    when :integer then
      factor=Number.new(acceptIt)
    when :lbracket then
      factor=ExprFactor.new
      acceptIt
      factor.expr=parseExpression()
      expect :rbracket
    when :tilde then
      factor=TildeFactor.new
      acceptIt
      factor.expr=parseFactor()
    else
      raise "expecting : identifier number '(' or '~' at #{lexer.pos}"
    end

    return factor
  end

  def parseSelector
    say "parseSelector"
    selector=Selector.new
    while showNext.kind==:dot or showNext.kind==:lsbracket
      case showNext.kind
      when :dot
        acceptIt
        id=expect :ident
        selector << IdentSelector.new(id)
      when :lsbracket
        acceptIt
        expr=parseExpression()
        expect :rsbracket
        selector << TabSelector.new(expr)
      else
        raise "wrong selector : expecting '.' or '['. Got '#{showNext.value}'"
        continuer = false
      end
    end
    return selector
  end
  
  def parseIfStatement()
    say "parseIfStatement"
    expect :if
    if_obj = If.new
    if_obj.cond = parseExpression()
    expect :then
    if_obj.ifBlock = parseStatementSequence()
    if_father_obj = if_obj
    while showNext.kind==:elsif
      acceptIt()
      if_son_obj = If.new
      if_son_obj.cond = parseExpression()
      expect :then
      if_son_obj.ifBlock = parseStatementSequence()
      if_father_obj.elseBlock = if_son_obj
      if_father_obj = if_son_obj
    end
    if showNext.kind==:else
	acceptIt()
	if_father_obj.elseBlock = parseStatementSequence()
    end
    expect :end
    return if_obj
  end

  def parseWhileStatement
    say "parseWhileStatement"
    expect :while
    while_obj = While.new
    while_obj.cond = parseExpression()
    expect :do
    while_obj.block = parseStatementSequence()
    expect :end
    return while_obj
  end

#---------------------------------------------------------
  def parseTerm
    term = Term.new
    say "parseTerm"
    term.lhs = parseFactor()
    starters_factor=[:multiply,:div,:mod,:and]
    while starters_factor.include? showNext.kind
      term.op = Operator.new(acceptIt)
      term.rhs = parseFactor()
    end 
    return term
  end

  def parseSimpleExpression
    say "parseSimpleExpression"
    expr=SimpleExpression.new
    sterm=SignedTerm.new
    if showNext.kind==:plus 
      sterm.op=Operator.new(acceptIt)
    elsif showNext.kind==:substract
      sterm.op=Operator.new(acceptIt)
    end
    sterm.term=parseTerm()
    expr.terms.push(sterm)
    while showNext.kind==:plus or showNext.kind==:substract or showNext.kind==:or
      sterm=SignedTerm.new
      sterm.op=Operator.new(acceptIt)
      sterm.term=parseTerm()
      expr.terms.push(sterm)
    end
    return expr
  end
	
  def parseFPSection
    node=FPSection.new
    say "parseFPSection"
    if (showNext.kind == :var)
      acceptIt
      node.isVar=true
    end
    node.identList=parseIdentList()
    expect :semicolon
    node.type=parseType()
    return node
  end
	
  def parseFormalParameters
    node=FormalParameters.new
    say "parseFormalParameters"
    expect :lbracket
    if (showNext.kind != :rbracket)
      node.fpsections.push(parseFPSection())
      while showNext.kind==:semicolon
        acceptIt
        node.fpsections.push(parseFPSection())
      end
    end
    expect :rbracket
    return node
  end

  def parseProcedureHeading
    node=ProcedureHeading.new
    say "parseProcedureHeading"
    expect :procedure
    node.name = Identifier.new(expect :ident)
    if showNext.kind==:lbracket
      node.formalParameters=parseFormalParameters()
    end
    return node
  end

  def parseStatement
    say "parseStatement"
    stmt = Stmt.new
    case showNext.kind
    when :ident then
      identifier=acceptIt()
      selector=parseSelector()
      if showNext().kind==:assign
        stmt=parseAssignment(identifier,selector)
      else
        stmt=parseProcedureCall(identifier,selector)
      end
    when :if then
      stmt=parseIfStatement()
    when :while then
      stmt=parseWhileStatement()
    else raise "expecting one of : identifier,if,while"
    end
    return stmt
  end

  def parseProcedureBody 
    say "parseProcedureBody"
    pb = ProcedureBody.new    
    pb.decls = parseDeclarations()
    if showNext.kind==:begin
      acceptIt
      pb.stmts = parseStatementSequence()
    end
    expect :end
    say id=expect(:ident)
    pb.ident = Identifier.new(id)
    return pb
  end       

 def parseProcedureDeclaration
   say "parseProcedureDeclaration"
   node= ProcedureDecl.new
   node.heading = parseProcedureHeading()
   expect :semicolon
   node.body = parseProcedureBody()
   return node
 end

 def parseDeclarations 
   say "parseDeclarations"
   declarations = Declarations.new
   
   if showNext.kind==:const
     acceptIt
     cst = ConstDeclarations.new  # :constDecls[]
     while showNext.kind==:ident
       cd = ConstDecl.new # : ident :expr
       cd.ident = Identifier.new(expect(:ident))
       expect :eq
       cd.expr = parseExpression()
       expect :semicolon
       cst.list << cd
     end
     declarations.consts << cst
   end
   
   if showNext.kind==:type
     acceptIt
     say "type detected"
     tpe = TypeDeclaration.new # :typeDecls[]
     while showNext.kind==:ident
       asgnmt = TypeDecl.new # : ident :type
       asgnmt.ident = Identifier.new(expect(:ident))
        expect :eq
       asgnmt.type = parseType()
       expect :semicolon
       tpe.typeDecls << asgnmt
     end
     declarations.types << tpe
   end
    
   if showNext.kind==:var
     acceptIt
     say "var detected"
     vars = VarDeclarations.new # :varDecls[]
     while showNext.kind==:ident
       vd = VarDecl.new # :identList :type
       vd.identList = parseIdentList()
       expect :colon
       vd.type = parseType()
       expect :semicolon
       vars.list << vd
     end
     declarations.vars << vars
   end
   
   if showNext.kind==:procedure
     procs = ProcedureDeclarations.new # :procDecls[]
     while showNext.kind==:procedure
       procs.list << parseProcedureDeclaration()
       expect :semicolon
     end
     declarations.procs << procs
   end
   return declarations
 end 
  
 def parseIdentList
   say "parseIdentList"
   node=IdentList.new
   node.idents << Identifier.new(expect(:ident))
   while showNext.kind==:comma
     acceptIt
     node.idents << Identifier.new(expect(:ident))
   end
   return node
 end

 def parseType
   node = Type.new
   say "parseType"
   case showNext.kind
   when :ident
     node = NamedType.new(Identifier.new(acceptIt))
   when :array
     node  = parseArrayType()
   when :record
     node = parseRecordType()
   else
     raise "parsing error for type around #{showNext.pos}"
   end
   return node
 end

 def parseArrayType
   node = ArrayType.new
   say "parseArrayType"
   expect :array
   node.size = parseExpression()
   expect :of
   node.type = parseType()
   return node
 end
 
 def parseRecordType
   rc = RecordType.new
   say "parseRecordType"
   expect :record
   rc.fieldLists << parseFieldList()
   while showNext.kind==:semicolon
     acceptIt
     rc.fieldLists << parseFieldList()
   end
   expect :end
   return rc
 end
 
 def parseFieldList
   node = FieldList.new
   say "parseFieldList"
   if showNext.kind==:ident
     node.identList = parseIdentList()
     expect :colon
     node.type = parseType()
   end
   return node
 end

 def parseActualParameters
   node=ActualParameters.new
   say "parseActualParameters"
   expect :lbracket
   starters_exp=[:plus,:minus,:ident,:integer,:lbracket,:tilde]
   if starters_exp.include? showNext.kind
     node.expressions.push(parseExpression())
     while showNext.kind==:comma
       node.expressions.push(parseExpression())
     end
   end
   expect :rbracket
   return node
 end
  

 def parseProcedureCall(identifier,selector)
   node=ProcedureCall.new
   node.name = Identifier.new(identifier)
   say "parseProcedureCall"
   #.....already parsed.......
   #expect :ident
   #parseSelector()
   #.........................
   if showNext.kind==:lbracket
     node.actualParams=parseActualParameters()
   end
   return node # ligne ajoutée
 end

 def parseAssignment(id_tok,selector)
   assignt=Assignment.new # ligne ajoutée
   assignt.ident = Identifier.new(id_tok) # ligne ajoutée
   assignt.selector = selector
   say "parseAssignement"
   # .....already analyzed......
   #expect :ident
   # @lexer.print_stream(5)
   #parseSelector()
   #...........................
   expect :assign
   assignt.expression=parseExpression() # ligne modifiée
   return assignt # ligne ajoutée
 end


end
